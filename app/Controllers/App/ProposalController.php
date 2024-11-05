<?php

namespace MaisAutonomia\Controllers\App;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;

class ProposalController extends Controller
{

  public function show(Request $request, Response $response): Response
  {
    $id_servico = $request->getAttribute('id_servico');

    return $this->view->render($response, 'proposal.html', [
      "id_servico" => $id_servico
    ]);
  }

  public function store(Request $request, Response $response): Response
  {
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
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/proposta/{$id_servico}?message=Você%20ja%20enviou%20uma%20proposta")
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
}
