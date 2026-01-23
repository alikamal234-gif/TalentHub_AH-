<?php

use App\Controller\Candidate\CandidateController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CandidateMiddleware;
use Core\Router\Router;

// Router::get('/candidate', [CandidateController::class, 'candidate'])
//     // ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
// ;
Router::get('/', [CandidateController::class, 'candidate']);


Router::get('/candidate/postuler', [CandidateController::class, 'postuler']);