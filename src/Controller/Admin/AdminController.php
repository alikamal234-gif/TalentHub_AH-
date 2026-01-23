<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Response;

class AdminController extends AbstractController
{
    public function admin(UserRepository $userRepository,OfferRepository $offerRepository): Response
    {
        $Candidate = $userRepository->countUserByRole("Candidate");
        $Recruiter = $userRepository->countUserByRole("Recruiter");
        $Offer = $offerRepository->countOffer();
        return $this->render("admin/admin.html.twig",[ "candidateCount" => $Candidate, "recruiterCount"=>$Recruiter, "offerCount" =>$Offer]);
    }
}
