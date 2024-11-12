<?php

namespace MaisAutonomia\Controllers\App;

use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MaisAutonomia\Database\Database;
use PDO;

class AppController extends Controller
{
  public function home(Request $request, Response $response)
  {
    $database = new Database();
    $stmt = $database->query()->prepare("SELECT * FROM servicos s WHERE s.id_cliente = :usuario");
    $stmt->execute([
      "usuario" => $_SESSION['user']['id_usuario']
    ]);
    $servicos = $stmt->fetchAll();

    return $this->view->render($response, 'home.html', [
      "servicos" => $servicos,
    ]);
  }

  public function messages(Request $request, Response $response)
  {
    $queries = $request->getQueryParams();

    return $this->view->render($response, 'messages.html', [
      "message" => isset($queries['message']) ? $queries['message'] : null
    ]);
  }
   
  public function profile(Request $request, Response $response)
  {
    $id = $request->getAttribute('id_usuario');

    $query = "SELECT * FROM usuario u WHERE u.id_usuario = :usuario";
    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      "usuario" => $id
    ]);

    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM formacao_experiencia f WHERE f.id_usuario = :usuario";
    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      "usuario" => $id
    ]);

    $pode_avaliar = false;

    if ($id !== $_SESSION['user']['id_usuario']) {
      $query = "SELECT COUNT(*) total FROM servicos s WHERE s.id_autonomo = :usuario";
      $stmt = (new Database())->query()->prepare($query);
      $stmt->execute([
        "usuario" => $id
      ]);

      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($resultado > 0) {
        $pode_avaliar = true;
      }
    }

    $formexps = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view->render($response, 'profile.html', [
      "usuario"      => $usuario[0],
      "formexps"     => $formexps,
      "pode_avaliar" => $pode_avaliar
    ]);
  }

  public function delete(Request $request, Response $response)
  {
    // Pegar o id da url 
    $id = $_GET['id'];
    // Criar o script de deletar
    $deletar = "DELETE FROM usuario WHERE id_user = :id";
    // Fazer a conexao com o banco
    $conexao = new Database();
    // Preparar o codigo sql
    $prepara = $conexao->query()->prepare($deletar);
    // inforoma o id que deve deletar
    $prepara->bindParam(':id', $id);
    // Deletar realemente o usuario
    $prepara->execute();

    session_destroy();

    header('Location:/MaisAutonomia');

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/?message=Deletado%20com%20sucesso!")
      ->withStatus(301);
  }

  public function rating(Request $request, Response $response): Response
  {
  
    $id_usuario = $request->getAttribute('id_usuario');
    $range = $_POST['range'];
    $avaliacao = $_POST['avaliacao'];

    if (empty($range) || empty($avaliacao)) {
      return $response->withHeader("Location", $_ENV['BASE_URL'] . "/me/perfil/{$id_usuario}?message=Preencha%20todos%20os%20campos%20para%20avaliar.")
      ->withStatus(301);
    }else{
      
      $query = "SELECT id_servicos FROM servicos WHERE id_cliente = :usuario";
      $stmt = (new Database())->query()->prepare($query);
      $stmt->execute([
          "usuario" => $id_usuario
      ]);

      $id_servicos= $stmt->fetchAll(PDO::FETCH_ASSOC);

      $id_servicos = $id_servicos[0]['id_servicos'];

      $query = "INSERT INTO avaliacao (id_usuario, id_servicos, titulo_avaliacao, desc_avaliacao, range_avaliacao)
                VALUES (:id_usuario, :id_servicos, :titulo_avaliacao, :desc_avaliacao, :range_avaliacao)";

      $stmt = (new Database())->query()->prepare($query);

      $stmt->execute([
          "id_usuario" => $_SESSION['user']['id_usuario'], 
          "id_servicos" => $id_servicos,  
          "titulo_avaliacao" => "Avaliação de serviço", 
          "desc_avaliacao" => $avaliacao, 
          "range_avaliacao" => $range, 
      ]);
  
      return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/perfil/{$id_usuario}?message=Avaliação%20enviada%20com%20sucesso!")
      ->withStatus(301);

    }
  }
}
