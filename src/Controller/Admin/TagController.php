<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Tag;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use Core\Controller\AbstractController;
use Core\Http\Request;
use Core\Http\Response;

class TagController extends AbstractController{
    public function __construct(private TagRepository $tagRepository)
    {
    }

    public function index(): Response
    {
        return $this->render('admin/tag/index.html.twig', ['tags' => $this->tagRepository->findAll()]);
    }
    public function create(): Response
    {
        return $this->render('admin/tag/create.html.twig');
    }

    public function trash(): Response
    {
        return $this->render('admin/tag/trash.html.twig', [
            'tags' => $this->tagRepository->findAllTrashed()
        ]);
    }
    
    public function delete(Request $request)
    {
        $id = (int) $request->query('id');
        $tag = $this->tagRepository->findTrashed($id);
        if ($tag) {
            $this->tagRepository->delete($tag);
        }

        $this->redirectToPath('/admin/tags/trash');
    }
    public function trashed(Request $request)
    {
        $id = (int) $request->query('id');
        $tag = $this->tagRepository->find($id);
        if ($tag) {
            $this->tagRepository->trashed($tag);
        }

        $this->redirectToPath('/admin/tags');
    }
    public function restore(Request $request)
    {
        $id = (int) $request->query('id');
        $tag = $this->tagRepository->findTrashed($id);
        if ($tag) {
            $this->tagRepository->restore($tag);
        }

        $this->redirectToPath('/admin/tags/trash');
    }
    public function store(Request $request)
    {
        $name = $request->input('name');

        $tag = new Tag($name);
        $this->tagRepository->save($tag);

        $this->redirectToPath('/admin/tags');
    }
    public function edit(Request $request): Response
    {
        $id = (int) $request->query('id');
        $tag = $this->tagRepository->find($id);

        if (!$tag) {
            $this->redirectToPath('/admin/tags');
        }

        return $this->render('admin/tag/edit.html.twig', ['tag' => $tag]);
    }
    public function update(Request $request)
    {
        $id = (int) $request->input('id');
        $name = $request->input('name');

        $tag = $this->tagRepository->find($id);

        if ($tag && $name) {
            $tag->setName($name);
            $this->tagRepository->save($tag);
        }

        $this->redirectToPath('/admin/tags');
    }
}