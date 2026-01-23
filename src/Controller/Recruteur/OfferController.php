<?php

namespace App\Controller\Recruteur;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use App\Repository\CategorieRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class OfferController extends AbstractController
{
    public function __construct(
        private OfferRepository $offerRepository,
        private CategorieRepository $categorieRepository
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->render('recruteur/offer/index.html.twig', [
            'offers' => $this->offerRepository->findAllByOwner($request->getUser())
        ]);
    }

    public function create(): Response
    {
        return $this->render('recruteur/offer/create.html.twig', [
            'categories' => $this->categorieRepository->findAll()
        ]);
    }

    public function store(Request $request)
    {
        $categoryId = (int) $request->input('category_id');
        $name = $request->input('name');
        $description = $request->input('description');
        $salary = (float) $request->input('salary');
        $city = $request->input('city');
        $contact = $request->input('contact');
        $company = $request->input('company');

        $category = $this->categorieRepository->find($categoryId);
        $owner = $request->getUser(); // Assuming user is in session

        $offer = new Offer(
            $category,
            $owner,
            $name,
            $description,
            $salary,
            $city,
            $contact,
            $company
        );

        $this->offerRepository->save($offer);

        $this->redirectToPath('/recruteur/offres');
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->query('id');
        $offer = $this->offerRepository->find($id);

        if (!$offer) {
            $this->redirectToPath('/recruteur/offres');
        }

        return $this->render('recruteur/offer/edit.html.twig', [
            'offer' => $offer,
            'categories' => $this->categorieRepository->findAll()
        ]);
    }

    public function update(Request $request)
    {
        $id = (int) $request->input('id');
        $categoryId = (int) $request->input('category_id');
        $name = $request->input('name');
        $description = $request->input('description');
        $salary = (float) $request->input('salary');
        $city = $request->input('city');
        $contact = $request->input('contact');
        $company = $request->input('company');

        $offer = $this->offerRepository->find($id);

        if ($offer) {
            $category = $this->categorieRepository->find($categoryId);
            $offer->setCategory($category);
            $offer->setName($name);
            $offer->setDescription($description);
            $offer->setSalary($salary);
            $offer->setCity($city);
            $offer->setContact($contact);
            $offer->setCompany($company);

            $this->offerRepository->save($offer);
        }

        $this->redirectToPath('/recruteur/offres');
    }

    public function trash(Request $request): Response
    {
        return $this->render('recruteur/offer/trash.html.twig', [
            'offers' => $this->offerRepository->findAllTrashedByOwner($request->getUser())
        ]);
    }

    public function restore(Request $request)
    {
        $id = (int) $request->query('id');
        $offer = $this->offerRepository->findTrashed($id);
        if ($offer) {
            $this->offerRepository->restore($offer);
        }

        $this->redirectToPath('/recruteur/offres/trash');
    }

    public function delete(Request $request)
    {
        $id = (int) $request->query('id');
        $offer = $this->offerRepository->findTrashed($id);
        if ($offer) {
            $this->offerRepository->delete($offer);
        }

        $this->redirectToPath('/recruteur/offres/trash');
    }

    public function trashed(Request $request)
    {
        $id = (int) $request->query('id');
        $offer = $this->offerRepository->find($id);
        if ($offer) {
            $this->offerRepository->trashed($offer);
        }

        $this->redirectToPath('/recruteur/offres');
    }
}