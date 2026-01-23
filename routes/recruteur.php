<?php

use App\Controller\Recruteur\CandidateController;
use App\Controller\Recruteur\OfferController;
use App\Controller\Recruteur\RecruteurController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RecruiterMiddleware;
use Core\Router\Router;

Router::get('/recruteur', [RecruteurController::class, 'recruteur'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class])
;

// offers
Router::get('/recruteur/offres', [OfferController::class, 'index'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/create', [OfferController::class, 'create'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::post('/recruteur/offres/store', [OfferController::class, 'store'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/edit', [OfferController::class, 'edit'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::post('/recruteur/offres/update', [OfferController::class, 'update'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/trash', [OfferController::class, 'trash'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/restore', [OfferController::class, 'restore'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/delete', [OfferController::class, 'delete'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/trashed', [OfferController::class, 'trashed'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/candidatures', [CandidateController::class, 'index'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/candidatures/accept', [CandidateController::class, 'accept'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);

Router::get('/recruteur/offres/candidatures/reject', [CandidateController::class, 'reject'])
    ->middleware([AuthMiddleware::class, RecruiterMiddleware::class]);
