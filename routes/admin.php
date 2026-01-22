<?php

use App\Controller\Admin\AdminController;
use Core\Router\Router;

Router::get('/admin', [AdminController::class, 'admin']);