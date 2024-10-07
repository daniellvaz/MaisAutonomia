<?php

namespace MaisAutonomia\Controllers\Web;

use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class SessionController extends Controller
{
  public function login(Request $request, Response $response): void
  {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $database = new Database();

    // Verifica o usuário no banco de dados
    $stmt = $database->query()->prepare("SELECT * FROM usuario WHERE email_user = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($senha, $usuario['senha_user'])) {
      header("Location: {$_ENV['BASE_URL']}/login?erro=Usuario%20ou%20nao%20conferem");
      return;
    }

    $_SESSION['user'] = $usuario;

    // Enviar email de validação (opcional)
    // ...

    // Redireciona para a página inicial (pode ser uma página de dashboard)
    header("Location: index.php?login=success");
  }
}
