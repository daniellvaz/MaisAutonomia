<?php

namespace MaisAutonomia\Controllers\App;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;
use PDO;

class ProposalController extends Controller
{
  public function index(Request $request, Response $response): Response
  {
    $offset = ($this->page - 1) * 5;
    $query = "
      SELECT 
        * 
      FROM propostas p 
      LEFT JOIN servicos s ON s.id_servicos = p.id_servico
      WHERE p.id_usuario = :usuario
      LIMIT 5 OFFSET {$offset}
    ";

    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      'usuario' => $_SESSION['user']['id_usuario']
    ]);
    $propostas = $stmt->fetchAll();

    return $this->view->render($response, 'proposals.html', [
      "propostas" => $propostas,
      "page"      => $this->page,
      "has_more"  => true
    ]);
  }

  public function show(Request $request, Response $response): Response
  {
    $id_servico = $request->getAttribute('id_servico');

    return $this->view->render($response, 'proposal-create.html', [
      "id_servico" => $id_servico
    ]);
  }

  public function details(Request $request, Response $response): Response
  {
    $id = $request->getAttribute('id');
    $query = "SELECT * FROM propostas p LEFT JOIN servicos s ON s.id_servicos = p.id_servico WHERE p.id_proposta = :id";
    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id" => $id
    ]);

    $proposta = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view->render($response, 'proposal-details.html', [
      "proposta" => $proposta[0]
    ]);
  }

  public function store(Request $request, Response $response): Response
  {
    if (!isset($_SESSION['user'])) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/proposta/{$request->getAttribute('id_servico')}?message=Por%20favor,%20faça%20o%20login%20ou%20crie%20uma%20conta!")
        ->withStatus(301);
    }

    $database = new Database();

    $descricao_proposta = $_POST['descricao_proposta'];
    $valor_proposta     = $_POST['valor_proposta'];
    $id_usuario         = $_SESSION['user']['id_usuario'];
    $id_servico         = $request->getAttribute('id_servico');

    $encontra_proposta_criada = $database->query()->prepare(
      "
      SELECT 
        COUNT(*) as total
      FROM propostas p 
      WHERE 1 = 1
      AND p.id_servico = :servico 
      AND p.id_usuario = :usuario
      "
    );

    $encontra_proposta_criada->execute([
      "servico" => $id_servico,
      "usuario" => $id_usuario,
    ]);

    $resultado = $encontra_proposta_criada->fetchAll();
    $total_de_propostas = $resultado[0]['total'];

    if (intval($total_de_propostas) > 0) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/servico/{$id_servico}/proposta?message=Você%20ja%20enviou%20uma%20proposta")
        ->withStatus(301);
    }

    $query = "
      INSERT INTO propostas 
        (id_servico, id_usuario, descricao_proposta, valor_proposta) 
      VALUES 
        (:servico, :usuario, :descricao, :valor)
    ";

    $adiciona_proposta = $database->query()->prepare($query);

    $adiciona_proposta->execute([
      "servico"   => $id_servico,
      "usuario"   => $id_usuario,
      "descricao" => $descricao_proposta,
      "valor"     => $valor_proposta,
    ]);

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?message=Proposta%20enviada%20com%20sucesso")
      ->withStatus(301);
  }

  public function update(Request $request, Response $response): Response
  {
    $id = $request->getAttribute('id');

    if (!isset($_POST['valor_proposta']) || intval($_POST['valor_proposta']) <= 50) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/proposta/{$id}?message=Insira um valor válido!")
        ->withStatus(301);
    }

    $valor = $_POST['valor_proposta'];
    $query = "SELECT * FROM propostas p WHERE p.id_proposta = :id";
    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id" => $id
    ]);

    $proposta = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($proposta[0])) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/proposta/{$id}?message=Proposta%20não%20encontrada!")
        ->withStatus(301);
    }

    $query = "UPDATE propostas SET propostas.valor_proposta = :valor WHERE propostas.id_proposta = :id";
    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      "id"    => $id,
      "valor" => $valor
    ]);

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/proposta/{$id}?message=Proposta%20atualiza%20com%20sucesso!")
      ->withStatus(301);
  }

  public function updateStatus(Request $request, Response $response): Response
  {
    $id = $request->getAttribute('id');
    $status = $request->getAttribute('status');

    $query = "SELECT * FROM propostas p WHERE p.id_proposta = :id";
    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id" => $id
    ]);

    $proposta = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($proposta[0])) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/servicos/{$proposta[0]['id_servico']}?message=Proposta%20não%20encontrada!")
        ->withStatus(301);
    }

    $query = "UPDATE propostas SET propostas.status_proposta = :status_proposta WHERE propostas.id_proposta = :id";
    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      "id"     => $id,
      "status_proposta" => $status
    ]);

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/servicos/{$proposta[0]['id_servico']}?message=Proposta%20{$status}!")
      ->withStatus(301);
  }
}
