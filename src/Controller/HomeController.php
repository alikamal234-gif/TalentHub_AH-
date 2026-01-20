<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Core\Http\Response;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render("index.html.twig");
    }
}