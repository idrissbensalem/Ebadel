<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Adminarticle')]
class ArticleAdminController extends AbstractController
{
    #[Route('/admin/article', name: 'app_article_admin', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article_admin/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }



}
