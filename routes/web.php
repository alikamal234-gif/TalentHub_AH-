<?php

use App\Controller\HomeController;
use App\Controller\Admin\AdminController;
use App\Controller\Candidate\CandidateController;
use App\Controller\Recruteur\RecruteurController;
use App\Controller\Auth\AuthentificationController;
use App\Middleware\AuthMiddleware;
use Core\Router\Router;

Router::get('/auth', [AuthentificationController::class, 'index']);
Router::post('/login', [AuthentificationController::class, 'login']);
Router::post('/register', [AuthentificationController::class, 'register']);
Router::get('/logout', [AuthentificationController::class, 'logout'])
    ->middleware(AuthMiddleware::class)
;

require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/candidate.php';
require_once __DIR__ . '/recruteur.php';
