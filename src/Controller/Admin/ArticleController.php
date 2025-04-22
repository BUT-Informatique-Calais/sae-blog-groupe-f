<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/article', name: 'admin.article.')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('admin/article/index.html.twig', compact('articles'));
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setPublishedAt(new \DateTimeImmutable());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', "L'article a bien été créé");
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('admin/article/new.html.twig', compact('form'));
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $entityManager) : Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "L'article a été modifié");
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('admin/article/edit.html.twig', compact('form'));
    }

    #[Route('/delete/{id}', name: 'delete', methods:['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }
 
        return $this->redirectToRoute('admin.article.index');
    }
}
