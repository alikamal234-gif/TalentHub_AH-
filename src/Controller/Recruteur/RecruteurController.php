<?php

namespace App\Controller\Recruteur;

use Core\Controller\AbstractController;
use Core\Http\Response;

class RecruteurController extends AbstractController
{
    public function recruteur(): Response
    {
        return $this->render("recruteur/recruteur.html.twig");
    }
}