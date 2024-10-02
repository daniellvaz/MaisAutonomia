<?php

use MaisAutonomia\Controllers\WebController;

$app->get('/', [WebController::class, 'home']);
