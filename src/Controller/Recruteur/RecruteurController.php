<?php

namespace App\Controller\Recruteur;

use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class RecruteurController extends AbstractController
{
    public function recruteur(Request $request ,OfferRepository $offerRepository,CandidatureRepository $candidatureRepository): Response
    {
        $Offer = $offerRepository->countOfferByRecruteur($request->getUser()->getId());
        $candidature = $candidatureRepository->countCandidatureByRecruteur($request->getUser()->getId());
        return $this->render("recruteur/index.html.twig",["offerCount" => $Offer,"candidateConversion" => $candidature]);
    }
}