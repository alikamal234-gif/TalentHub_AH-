<?php

namespace App\Controller\Candidate;

use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class CandidateController extends AbstractController
{
    public function candidate(Request $request): Response
    {
        $roleName = $request->getUser() ? $request->getUser()->getRole() : null;
        return $this->render("candidate/candidate.html.twig",['roleName' => $roleName]);
    }
    public function postuler(): Response
    {
        return $this->render("candidate/postuler.html.twig");
    }
}