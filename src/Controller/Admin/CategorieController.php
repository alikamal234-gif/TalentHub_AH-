<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class CategorieController extends AbstractController
{
    public function __construct(private CategorieRepository $categorieRepository)
    {
    }

    public function index(): Response
    {
        return $this->render('admin/categorie/index.html.twig', ['categories' => $this->categorieRepository->findAll()]);
    }

    public function create(): Response
    {
        return $this->render('admin/categorie/create.html.twig');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');

        $categorie = new Categorie($name);
        $this->categorieRepository->save($categorie);

        $this->redirectToPath('/admin/categories');
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->query('id');
        $categorie = $this->categorieRepository->find($id);

        if (!$categorie) {
            $this->redirectToPath('/admin/categories');
        }

        return $this->render('admin/categorie/edit.html.twig', ['categorie' => $categorie]);
    }

    public function update(Request $request)
    {
        $id = (int) $request->input('id');
        $name = $request->input('name');

        $categorie = $this->categorieRepository->find($id);

        if ($categorie && $name) {
            $categorie->setName($name);
            $this->categorieRepository->save($categorie);
        }

        $this->redirectToPath('/admin/categories');
    }

    public function delete(Request $request)
    {
        $id = (int) $request->query('id');
        $categorie = $this->categorieRepository->find($id);
        if ($categorie) {
            $this->categorieRepository->delete($categorie);
        }

        $this->redirectToPath('/admin/categories');
    }

    public function trashed(Request $request)
    {
        $id = (int) $request->query('id');
        $categorie = $this->categorieRepository->find($id);
        if ($categorie) {
            $this->categorieRepository->trashed($categorie);
        }

        $this->redirectToPath('/admin/categories');
    }
}