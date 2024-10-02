<?php

use MaisAutonomia\Controllers\App\AppController;

$app->get('/me/inicio', [AppController::class, 'home']);
$app->get('/me/servicos/{id}', [AppController::class, 'details']);
