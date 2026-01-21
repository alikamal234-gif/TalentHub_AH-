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
}