<?php

use MaisAutonomia\Controllers\Web\WebController;

$app->get('/', [WebController::class, 'home']);
$app->get('/login', [WebController::class, 'login']);
$app->get('/cadastro', [WebController::class, 'register']);