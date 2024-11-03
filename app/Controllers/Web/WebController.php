<?php

namespace MaisAutonomia\Controllers\Web;

use MaisAutonomia\Controllers\Controller;
use MaisAutonomia\Database\Database;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WebController extends Controller
{
  public function home(Request $request, Response $response)
  {
    $query = "SELECT * FROM servicos s WHERE s.titulo_servicos LIKE :titulo";
    $smtm = (new Database())->query()->prepare($query);
    $smtm->execute([
      "titulo" => $_GET['titulo'] ?? '%%'
    ]);
    $servicos = $smtm->fetchAll();

    return $this->view->render($response, 'index.html', [
      "servicos" => $servicos,
    ]);
  }

  public function login(Request $request, Response $response)
  {
    $error = isset($_GET['erro']) ? $_GET['erro'] : null;

    return $this->view->render($response, 'login.html', [
      "error" => $error
    ]);
  }

  public function register(Request $request, Response $response)
  {
    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

    return $this->view->render($response, 'register.html', [
      "erro" => $erro
    ]);
  } 

  public function servicos(Request $request, Response $response)
  {
    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

   
    return $this->view->render($response, 'cadastroservicos.html', [
      "erro" => $erro
    ]);
  }
}
