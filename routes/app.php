<?php

use MaisAutonomia\Controllers\App\AppController;
use MaisAutonomia\Controllers\App\ServiceController;
use MaisAutonomia\Controllers\App\ProposalController;

$app->get('/me/inicio', [AppController::class, 'home']);
$app->get('/me/perfil', [AppController::class, 'profile']);
$app->get('/me/menssagens', [AppController::class, 'messages']);

$app->get('/me/servicos/{id}', [ServiceController::class, 'show']);
$app->post('/me/servicos/cadastro', [ServiceController::class, 'store']);
$app->post('/me/servicos/atualiza/{id}', [ServiceController::class, 'update']);
$app->delete('/me/servicos/deletar/{id}', [ServiceController::class, 'delete']);

$app->get('/me/propostas', [ProposalController::class, 'index']);
$app->get('/me/proposta/{id}', [ProposalController::class, 'details']);
$app->post('/me/proposta/{id}/atualizar', [ProposalController::class, 'update']);
$app->get('/me/servico/{id_servico}/proposta', [ProposalController::class, 'show']);
$app->post('/me/servico/{id_servico}/proposta', [ProposalController::class, 'store']);
$app->patch('/me/proposta/{id}/atualizar/{status}', [ProposalController::class, 'updateStatus']);

$app->get('/me/deletar/usuario', [AppController::class, 'delete']);