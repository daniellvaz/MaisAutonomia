<?php

namespace MaisAutonomia\Controllers;

use Slim\Views\Twig;
use Twig\TwigFunction;

class Controller
{
  /**
   * Summary of view
   * @var \Slim\Views\Twig $view
   */
  public $view = null;

  /**
   * Class constructor.
   */
  public function __construct()
  {
    $this->view = Twig::create(__DIR__ . '/../../resources/views', ['cache' => false]);
    $this->view->offsetSet('user', isset($_SESSION["user"]) ? $_SESSION["user"] : null);
    $this->view->getEnvironment()->addFunction(new TwigFunction("url", function (?string $uri = null) {
      if ($uri) {
        return $_ENV['BASE_URL'] . $uri;
      }

      return $_ENV['BASE_URL'];
    }));
  }
}
