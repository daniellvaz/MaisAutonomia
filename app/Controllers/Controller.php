<?php

namespace MaisAutonomia\Controllers;

use Slim\Views\Twig;
use Twig\TwigFunction;

class Controller
{
  public $view = null;

  /**
   * Class constructor.
   */
  public function __construct($data)
  {
    $this->view = Twig::create(__DIR__ . '/../../resources/views', ['cache' => false]);
    $this->view->getEnvironment()->addFunction(new TwigFunction("url", function (?string $uri = null) {
      if ($uri) {
        return $_ENV['BASE_URL'] . $uri;
      }

      return $_ENV['BASE_URL'];
    }));
  }
}
