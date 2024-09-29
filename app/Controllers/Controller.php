<?php

namespace MaisAutonomia\Controllers;

use Slim\Views\Twig;

class Controller
{
  public $view = null;

  /**
   * Class constructor.
   */
  public function __construct($data)
  {
    $this->view = Twig::create(__DIR__ . '/../../resources/views', ['cache' => false]);
  }
}
