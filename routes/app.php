<?php

use MaisAutonomia\Controllers\App\AppController;
use MaisAutonomia\Controllers\App\ProposalController;
use MaisAutonomia\Controllers\App\ServiceController;

$app->get('/me/inicio', [AppController::class, 'home']);
$app->get('/me/perfil', [AppController::class, 'profile']);
$app->get('/me/menssagens', [AppController::class, 'messages']);

$app->get('/me/servicos/{id}', [AppController::class, 'details']);
$app->post('/me/servicos/cadastro', [ServiceController::class, 'store']);
$app->post('/me/servicos/atualiza/{id}', [ServiceController::class, 'update']);
$app->delete('/me/servicos/deletar/{id}', [ServiceController::class, 'delete']);

$app->get('/me/proposta/{id_servico}', [ProposalController::class, 'show']);
$app->post('/me/proposta/{id_servico}/nova', [ProposalController::class, 'store']);

$app->get('/me/deletar/usuario', [AppController::class, 'delete']);