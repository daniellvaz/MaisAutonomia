<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . "/../vendor/autoload.php";

session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();
$twig = Twig::create(__DIR__ . '/../resources/views', ['cache' => false]);

$app = AppFactory::create();
$app->setBasePath($_ENV['BASE_PATH']);

$app->add(TwigMiddleware::create($app, $twig));
$app->get('/assets/{file:.+}', function (Request $request, Response $response, array $args) {
  $filePath = __DIR__ . '/../resources/assets/' . $args['file'];

  if (!file_exists($filePath)) {
    return $response->withStatus(404);
  }

  $fileType = mime_content_type($filePath);
  $response = $response->withHeader('Content-Type', $fileType);
  $response->getBody()->write(file_get_contents($filePath));

  return $response;
});

require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/app.php';

$app->run();
