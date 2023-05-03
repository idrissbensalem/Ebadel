<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchBoutiqueType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/Adminarticle')]
class ArticleAdminController extends AbstractController
{
    #[Route('/', name: 'app_article_admin', methods: ['GET'])]
    public function index(Request $request2,   Request $request  , ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(SearchBoutiqueType::class);
            $search = $form->handleRequest($request2);
    
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Article::class)
                ->createQueryBuilder('u');
    
            //$desc= $boutiqueRepository->findBy([],['date_boutique'=>'DESC']);
            $articles  = new Paginator($query);
            $currentPage = $request->query->getInt('page', 1);
    
            $itemsPerPage = 3;
            $articles
                ->getQuery()
                ->setFirstResult($itemsPerPage * ($currentPage - 1))
                ->setMaxResults($itemsPerPage);
            $totalItems = count($articles);
            $pagesCount = ceil($totalItems / $itemsPerPage);
            if ($form->isSubmitted() && $form->isValid()) {
                $articles =  $articleRepository->search($search->get('mots')->getData());
                // $articles = new Paginator($boutiqueRepository->findBy([], ['date_boutique' => 'DESC']));
                $currentPage = $request->query->getInt('page', 1);
                $totalItems = count($articles);
                $pagesCount = ceil($totalItems / $itemsPerPage);
                return $this->render('article_admin/index.html.twig', [
                    'form' => $form->createView(),
                    'articles' => $articles,
    
                    'currentPage' => $currentPage,
                    'pagesCount' => $pagesCount,
                ]);
            }
            return $this->render('article_admin/index.html.twig', [
                'form' => $form->createView(),
                'articles' => $articles,
                //'desc' => $desc,
                'currentPage' => $currentPage,
                'pagesCount' => $pagesCount,
    
    
            ]);
    
    }
    


}
