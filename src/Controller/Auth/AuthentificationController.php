<?php

namespace App\Controller\Auth;

use Core\Controller\AbstractController;
use Core\Http\Response;

class AuthentificationController extends AbstractController
{
    public function login(): Response
    {
        return $this->render("auth/login.html.twig");
    }
    
}