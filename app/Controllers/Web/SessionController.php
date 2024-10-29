<?php
namespace MaisAutonomia\Controllers\Web;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;

class SessionController extends Controller
{
  public function login(Request $request, Response $response): Response
  {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $database = new Database();

    // Verifica o usuário no banco de dados
    $stmt = $database->query()->prepare("SELECT * FROM usuario WHERE email_user = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($senha, $usuario['senha_user'])) {
      return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/login?erro=Usuário%20ou%20senha%20não%20conferem!")
        ->withStatus(301);
    }

    $_SESSION['user'] = $usuario;

    // Enviar email de validação (opcional)
    // ...

    // Redireciona para a página inicial (pode ser uma página de dashboard)
    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/")
      ->withStatus(301);
  }

  public function logout(Request $request, Response $response): response
  {
    session_destroy();

    return $response
      ->withHeader('Location', $_ENV['BASE_URL'] . "/")
      ->withStatus(301);
  }
}
