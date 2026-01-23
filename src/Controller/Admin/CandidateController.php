<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class CandidateController extends AbstractController
{
    public function candidate(Request $request,UserRepository $userRepository): Response
    {
        $candidates = $userRepository->getAllByRole("Candidate");
        return $this->render("admin/candidate/index.html.twig",["candidates" => $candidates]);
    }
}
