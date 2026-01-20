<?php

use App\Controller\HomeController;
use Core\Router\Router;

Router::get('/', [HomeController::class, 'index']);