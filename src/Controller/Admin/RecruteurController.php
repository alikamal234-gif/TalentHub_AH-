<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class RecruteurController extends AbstractController
{
    public function Recruteur(Request $request,UserRepository $userRepository): Response
    {
        $recruiter = $userRepository->getAllByRole("Recruiter");
        return $this->render("admin/recruteure/index.html.twig",["recruiters" => $recruiter]);
    }
}
