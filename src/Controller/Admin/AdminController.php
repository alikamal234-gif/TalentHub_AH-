<?php

namespace App\Controller\Admin;

use Core\Controller\AbstractController;
use Core\Http\Response;

class AdminController extends AbstractController
{
    public function admin(): Response
    {
        return $this->render("admin/admin.html.twig");
    }
}
