<?php

namespace App\Controller\Recruteur;

use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use Core\Controller\AbstractController;
use Core\Http\Redirect;
use Core\Http\Request;

class CandidateController extends AbstractController
{
    public function __construct(private CandidatureRepository $candidatureRepository, private OfferRepository $offerRepository)
    {
    }

    public function index(Request $request)
    {
        $offer = $this->offerRepository->find((int) $request->query('id'));
        if (!$offer) {
            $this->redirectToPath('/recruteur/offres');
        }
        return $this->render('recruteur/candidates/index.html.twig', [
            'offer' => $offer,
            'candidatures' => $this->candidatureRepository->findAllByOffer($offer),
        ]);
    }

    public function accept(Request $request)
    {
        $candidature = $this->candidatureRepository->find((int) $request->query('id'));
        if (!$candidature) {
            $this->redirectToPath('/recruteur/offres');
        }
        $candidature->accept();
        $this->candidatureRepository->save($candidature);
        Redirect::back();
    }

    public function reject(Request $request)
    {
        $candidature = $this->candidatureRepository->find((int) $request->query('id'));
        if (!$candidature) {
            $this->redirectToPath('/recruteur/offres');
        }
        $candidature->reject();
        $this->candidatureRepository->save($candidature);
        Redirect::back();
    }
}