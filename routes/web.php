<?php

use App\Controller\HomeController;
use App\Controller\Admin\AdminController;
use App\Controller\Candidate\CandidateController;
use App\Controller\Recruteur\RecruteurController;
use App\Controller\Auth\AuthentificationController;
use Core\Router\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/admin', [AdminController::class, 'admin']);
Router::get('/candidate', [CandidateController::class, 'candidate']);
Router::get('/recruteur', [RecruteurController::class, 'recruteur']);
Router::get('/login', [AuthentificationController::class, 'login']);
Router::get('/postuler', [CandidateController::class, 'postuler']);
