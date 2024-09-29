<?php

namespace MaisAutonomia\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WebController extends Controller
{
  public function home(Request $request, Response $response)
  {
    return $this->view->render($response, 'index.html.twig');
  }
}
