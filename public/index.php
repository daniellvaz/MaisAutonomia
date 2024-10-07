<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . "/../vendor/autoload.php";

session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();
$twig = Twig::create(__DIR__ . '/../resources/views', ['cache' => false]);

$app = AppFactory::create();
$app->setBasePath($_ENV['BASE_PATH']);


$app->add(TwigMiddleware::create($app, $twig));
// Middleware para servir arquivos estáticos da pasta resources/assets
$app->get('/assets/{file:.+}', function (Request $request, Response $response, array $args) {
  $filePath = __DIR__ . '/../resources/assets/' . $args['file'];

  // Verifica se o arquivo existe
  if (!file_exists($filePath)) {
    return $response->withStatus(404);
  }

  // Define o tipo de conteúdo corretamente
  $fileType = mime_content_type($filePath);
  $response = $response->withHeader('Content-Type', $fileType);

  // Lê o conteúdo do arquivo
  $response->getBody()->write(file_get_contents($filePath));

  return $response;
});

require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/app.php';

$app->run();