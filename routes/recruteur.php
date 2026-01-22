<?php

use App\Controller\Recruteur\RecruteurController;
use Core\Router\Router;

Router::get('/recruteur', [RecruteurController::class, 'recruteur']);