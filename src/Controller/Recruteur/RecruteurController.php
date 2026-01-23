<?php

namespace App\Controller\Recruteur;

use App\Repository\OfferRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class RecruteurController extends AbstractController
{
    public function recruteur(Request $request ,OfferRepository $offerRepository): Response
    {
        $Offer = $offerRepository->countOfferByRecruteur($request->getUser()->getId());
        return $this->render("recruteur/index.html.twig",["offerCount" => $Offer]);
    }
}