<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Response;

class AdminController extends AbstractController
{
    public function admin(UserRepository $userRepository,OfferRepository $offerRepository, CandidatureRepository $candidatureRepository): Response
    {
        $Candidate = $userRepository->countUserByRole("Candidate");
        $Recruiter = $userRepository->countUserByRole("Recruiter");
        $Offer = $offerRepository->countOffer();
        $Candidature = $candidatureRepository->countCandidature();
        return $this->render("admin/admin.html.twig",[ "candidateCount" => $Candidate, "recruiterCount"=>$Recruiter, "offerCount" =>$Offer, "candidatureCount" => $Candidature]);
    }
}
