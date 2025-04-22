<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categorie', name: 'admin.categorie.')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('admin/categorie/index.html.twig', compact('categories'));
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', "La catégorie a bien été créée");
            return $this->redirectToRoute('admin.categorie.index');
        }

        return $this->render('admin/categorie/new.html.twig', compact('form'));
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $entityManager) : Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "La catégorie a été modifiée");
            return $this->redirectToRoute('admin.categorie.index');
        }

        return $this->render('admin/categorie/edit.html.twig', compact('form'));
    }

    #[Route('/delete/{id}', name: 'delete', methods:['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }
 
        return $this->redirectToRoute('admin.categorie.index');
    }

    #[Route('/{id}', name: 'show')]
    public function show(Categorie $categorie, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findByCategorie($categorie);
        return $this->render('admin/categorie/show.html.twig', compact('categorie', 'articles'));
    }
}
