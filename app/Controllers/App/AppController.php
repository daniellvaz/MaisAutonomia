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
    $id = $_SESSION['user']['id_usuario'];
    $query = "SELECT * FROM formacao_experiencia f WHERE f.id_usuario = :usuario";
    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute([
      "usuario" => $id
    ]);

    $formexps = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view->render($response, 'profile.html', [
      "formexps" => $formexps
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
  }
}
