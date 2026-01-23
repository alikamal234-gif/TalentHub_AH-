<?php

use App\Controller\Admin\AdminController;
use App\Controller\Admin\CategorieController;
use App\Controller\Admin\CandidateController;
use App\Controller\Admin\RecruteurController;
use App\Controller\Admin\TagController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use Core\Router\Router;

Router::get('/admin', [AdminController::class, 'admin'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class])
;

// Router of categories
Router::get('/admin/categories', [CategorieController::class, 'index'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// create
Router::get('/admin/categories/create', [CategorieController::class, 'create'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::post('/admin/categories/store', [CategorieController::class, 'store'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// edit
Router::get('/admin/categories/edit', [CategorieController::class, 'edit'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::post('/admin/categories/update', [CategorieController::class, 'update'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// delete
Router::get('/admin/categories/delete', [CategorieController::class, 'delete'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/categories/trash', [CategorieController::class, 'trash'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/categories/trashed', [CategorieController::class, 'trashed'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/categories/restore', [CategorieController::class, 'restore'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);






// Router of tags
Router::get('/admin/tags', [TagController::class, 'index'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class]);
;

// create
Router::get('/admin/tags/create', [TagController::class, 'create'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class]);
;
Router::post('/admin/tags/store', [TagController::class, 'store'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// edit
Router::get('/admin/tags/edit', [TagController::class, 'edit'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::post('/admin/tag/update', [TagController::class, 'update'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// delete
Router::get('/admin/tags/delete', [TagController::class, 'delete'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/tags/trash', [TagController::class, 'trash'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/tags/trashed', [TagController::class, 'trashed'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
Router::get('/admin/tags/restore', [TagController::class, 'restore'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);


// Router of candidate
Router::get('/admin/candidate', [CandidateController::class, 'candidate'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// Router of Recruiter
Router::get('/admin/recruiter', [RecruteurController::class, 'Recruteur'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
