<?php

namespace MaisAutonomia\Controllers\App;

use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AppController extends Controller
{
  public function home(Request $request, Response $response)
  {
    return $this->view->render($response, 'home.html');
  }

  public function details(Request $request, Response $response)
  {
    return $this->view->render($response, 'details.html');
  }
}
