<?php

namespace App\Controller\Candidate;

use App\Entity\Candidature;
use App\Repository\CandidatureRepository;
use App\Repository\OfferRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class CandidatureController extends AbstractController {

    public function store(Request $request, CandidatureRepository $candidatureRepository, OfferRepository $offerRepository)
{
    $user = $request->getUser();
    $offre = $offerRepository->find((int)$request->input('id'));
    $message = $request->input('message');

    $candidature = new Candidature($user, $offre, $message);

    $file = $request->file('cv');

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $cvContent = file_get_contents($file['tmp_name']); 
        $candidature->setCv($cvContent);
    } else {
        throw new \RuntimeException("CV is required");
    }

    $candidatureRepository->save($candidature);

    $this->redirectToPath('/candidate');
}

}