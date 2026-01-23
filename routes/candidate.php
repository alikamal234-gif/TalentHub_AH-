<?php

use App\Controller\Candidate\CandidateController;
use App\Controller\Candidate\ProfileController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CandidateMiddleware;
use Core\Router\Router;

Router::get('/candidate', [CandidateController::class, 'candidate'])
//     // ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
;

Router::get('/candidate/profile', [ProfileController::class, 'index'])
    ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
;

Router::post('/candidate/profile/update', [ProfileController::class, 'update'])
    ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
;

Router::post('/candidate/profile/password', [ProfileController::class, 'changePassword'])
    ->middleware([AuthMiddleware::class, CandidateMiddleware::class])
;

Router::get('/candidate/postuler', [CandidateController::class, 'postuler'])->middleware(AuthMiddleware::class);
