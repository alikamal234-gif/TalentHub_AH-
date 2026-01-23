<?php

use App\Controller\Admin\AdminController;
use App\Controller\Admin\CategorieController;
use App\Controller\Admin\TagController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use Core\Router\Router;

Router::get('/admin', [AdminController::class, 'admin'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class])
;

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
Router::get('/admin/categories/trash', [CategorieController::class, 'trash']);
Router::get('/admin/categories/trashed', [CategorieController::class, 'trashed']);
Router::get('/admin/categories/restore', [CategorieController::class, 'restore']);






// Router of tags
Router::get('/admin/tags', [TagController::class, 'index']);

// create
Router::get('/admin/tags/create', [TagController::class, 'create']);
Router::post('/admin/tags/store', [TagController::class, 'store']);

// edit
Router::get('/admin/tags/edit', [TagController::class, 'edit']);
Router::post('/admin/tag/update', [TagController::class, 'update']);

// delete
Router::get('/admin/tags/delete', [TagController::class, 'delete']);
Router::get('/admin/tags/trash', [TagController::class, 'trash']);
Router::get('/admin/tags/trashed', [TagController::class, 'trashed']);
Router::get('/admin/tags/restore', [TagController::class, 'restore']);