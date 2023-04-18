<?php

namespace App\Controller;

use App\Form\OffreType;
use App\Entity\Article;
use App\Entity\Offre;
use App\Controller\OffreController;
use App\Form\ArticleType;
use App\Repository\MesArticlesRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/mesarticles')]
class MesArticlesController extends AbstractController
{

#[Route('/', name: 'app_mesarticles_index', methods: ['GET'])]
public function index(MesArticlesRepository $mesarticlesRepository): Response
{
    $userId = 1;
    $mesarticles = $mesarticlesRepository->findAll();

    return $this->render('mes_articles/index.html.twig', [
        'mesarticles' => $mesarticles,
    ]);
}


    
    
    
/*
    #[Route('/{id}', name: 'app_article_offres', methods: ['GET'])]
    public function showoffres(Article $article): Response
    {
        $offres = $article->getOffres();
        return $this->render('article/show.html.twig', [
            'offres' => $offres,
            'article' => $article,
        ]);
    }*/

    #[Route('/{id}', name: 'app_mesarticles_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        $id = $article->getIdArticle();
        $nom = $article->getNomArticle();
        $categorie = $article->getCategorie();
        $sousCategorie = $article->getSousCategorie();
        $marque = $article->getMarque();
        $periodeUtilisation = $article-> getPeriodeUtilisation();
        $etat = $article->getEtat();
        $description = $article->getDescription();
        $image = $article->getImage();
        $offres = $article->getOffres();
    
        return $this->render('mes_articles/show.html.twig', [
            'id' => $id,
            'nom' => $nom,
            'categorie' => $categorie,
            'sousCategorie' => $sousCategorie,
            'marque' => $marque,
            'periodeUtilisation' => $periodeUtilisation,
            'etat' => $etat,
            'description' => $description,
            'image' => $image,
            'offres' => $offres,
        ]);
    }






    #[Route('/{id}/edit', name: 'app_mesarticles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, MesArticlesRepository $mesarticlesRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('image')->getData();
    
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
    
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
    
                $article->setImage($newFilename);
            }
    
            $mesarticlesRepository->save($article, true);
    
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('mes_articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mesarticles_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, MesArticlesRepository $mesarticlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getIdArticle(), $request->request->get('_token'))) {
            $mesarticlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_mesarticles_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
