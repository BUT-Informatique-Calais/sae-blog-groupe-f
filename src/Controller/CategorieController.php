<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie', name: 'categorie.')]
class CategorieController extends AbstractController
{
    #[Route('/{id}', name: 'show')]
    public function show(Categorie $categorie, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findByCategorie($categorie);
        return $this->render('categorie/show.html.twig', compact('categorie', 'articles'));
    }
}
