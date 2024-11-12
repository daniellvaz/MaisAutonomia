<?php

namespace MaisAutonomia\Controllers\Web;

use MaisAutonomia\Controllers\Controller;
use MaisAutonomia\Database\Database;
use PDO;
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

    return $this->view->render($response, 'index.html');
  }

  public function jobs(Request $request, Response $response): Response
  {
    $offset = ($this->page - 1) * 5;

    $query = "
      SELECT 
        *
      FROM servicos s 
      LIMIT 5 OFFSET {$offset}
    ";

    $stmt = (new Database())->query()->prepare($query);
    $stmt->execute();

    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = (new Database())->query()->prepare("SELECT COUNT(*) as total FROM servicos");
    $stmt->execute();
    $total = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view->render($response, 'jobs.html', [
      "servicos" => $servicos,
      "page"     => $this->page,
      "has_more" => true
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
