<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Response;

class AdminController extends AbstractController
{
    public function admin(UserRepository $userRepository): Response
    {
        $Candidate = $userRepository->countUserByRole("Candidate");
        $Recruiter = $userRepository->countUserByRole("Recruiter");
        return $this->render("admin/admin.html.twig",[ "candidateCount" => $Candidate, "recruiterCount"=>$Recruiter]);
    }
}
