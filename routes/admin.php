<?php

use App\Controller\Admin\AdminController;
use App\Controller\Admin\CategorieController;
use Core\Router\Router;

Router::get('/admin', [AdminController::class, 'admin']);

// Router of categories
Router::get('/admin/categories', [CategorieController::class, 'index']);

// create
Router::get('/admin/categories/create', [CategorieController::class, 'create']);
Router::post('/admin/categories/store', [CategorieController::class, 'store']);

// edit
Router::get('/admin/categories/edit', [CategorieController::class, 'edit']);
Router::post('/admin/categories/update', [CategorieController::class, 'update']);

// delete
Router::get('/admin/categories/delete', [CategorieController::class, 'delete']);
Router::get('/admin/categories/trashed', [CategorieController::class, 'trashed']);