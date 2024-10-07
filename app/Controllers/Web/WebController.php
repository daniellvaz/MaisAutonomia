<?php

namespace MaisAutonomia\Controllers\Web;

use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WebController extends Controller
{
  public function home(Request $request, Response $response)
  {
    return $this->view->render($response, 'index.html');
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
    return $this->view->render($response, 'register.html');
  }
}
