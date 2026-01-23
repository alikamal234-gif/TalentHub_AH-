<?php

namespace App\Controller\Candidate;

use App\Repository\OfferRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class CandidateController extends AbstractController
{
    public function candidate(Request $request,OfferRepository $offerRepository): Response
    {
        $roleName = $request->getUser() ? $request->getUser()->getRole() : null;
        $Offres = $offerRepository->findAll();
        
        return $this->render("candidate/candidate.html.twig",['roleName' => $roleName,'offres' => $Offres]);
    }
   
    public function postuler(Request $request, OfferRepository $offerRepository)
{
    $id = $request->query('id');  

    if (!$id) {
        dd("ID not found in URL");
    }

    $offre = $offerRepository->find($id);

    if (!$offre) {
        dd("Offer not found");
    }

    return $this->render('candidate/postuler.html.twig', [
        'offre' => $offre
    ]);
}
}