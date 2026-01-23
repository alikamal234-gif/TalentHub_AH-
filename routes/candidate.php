<?php

use App\Controller\Candidate\CandidateController;
use App\Controller\Candidate\CandidatureController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CandidateMiddleware;
use Core\Router\Router;

Router::get('/candidate', [CandidateController::class, 'candidate'])
//     // ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
;


Router::get('/candidate/postuler', [CandidateController::class, 'postuler'])->middleware(AuthMiddleware::class);
Router::post('/candidate/postuler', [CandidatureController::class, 'store'])->middleware(AuthMiddleware::class);