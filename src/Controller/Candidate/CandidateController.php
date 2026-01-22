<?php

namespace App\Controller\Candidate;

use Core\Controller\AbstractController;
use Core\Http\Response;

class CandidateController extends AbstractController
{
    public function candidate(): Response
    {
        return $this->render("candidate/candidate.html.twig");
    }
    public function postuler(): Response
    {
        return $this->render("candidate/postuler.html.twig");
    }
}