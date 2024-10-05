<?php

use MaisAutonomia\Controllers\App\AppController;

$app->get('/me/inicio', [AppController::class, 'home']);
$app->get('/me/perfil', [AppController::class, 'profile']);
$app->get('/me/menssagens', [AppController::class, 'messages']);
$app->get('/me/servicos/{id}', [AppController::class, 'details']);

$app->get('/me/deletar/usuario', [AppController::class, 'delete']);