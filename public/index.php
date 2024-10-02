<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();
$app->setBasePath($_ENV['BASE_PATH']);

$twig = Twig::create(__DIR__ . '/../resources/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

require __DIR__ . '/../routes/web.php';

$app->run();
