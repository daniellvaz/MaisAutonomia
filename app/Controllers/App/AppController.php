<?php

namespace MaisAutonomia\Controllers\App;

use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AppController extends Controller
{
  public function home(Request $request, Response $response)
  {
    $queries = $request->getQueryParams();

    return $this->view->render($response, 'home.html', [
      "profile" => isset($queries['profile']) ? $queries['profile'] : 'cliente'
    ]);
  }

  public function details(Request $request, Response $response)
  {
    $queries = $request->getQueryParams();

    return $this->view->render($response, 'details.html', [
      "profile" => isset($queries['profile']) ? $queries['profile'] : 'cliente'
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
    return $this->view->render($response, 'profile.html');
  }
}
