<?php

use App\Controller\Candidate\CandidateController;
use Core\Router\Router;

Router::get('/candidate', [CandidateController::class, 'candidate']);

Router::get('/postuler', [CandidateController::class, 'postuler']);