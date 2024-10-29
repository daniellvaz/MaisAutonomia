<?php

use MaisAutonomia\Controllers\Web\AccountController;
use MaisAutonomia\Controllers\Web\SessionController;
use MaisAutonomia\Controllers\Web\WebController;

$app->get('/', [WebController::class, 'home']);
$app->get('/login', [WebController::class, 'login']);
$app->get('/cadastro', [WebController::class, 'register']);

$app->post('/login', [SessionController::class, 'login']);
$app->get('/logout', [SessionController::class, 'logout']);

$app->post('/account/store', [AccountController::class, 'store']);

$app->get('/servicos/cadastro', [WebController::class, 'servicos']);

