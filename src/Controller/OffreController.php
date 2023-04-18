<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OffreType;
use App\Entity\Article;
use App\Entity\Offre;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\OffreRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('offre/index.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

   #[Route('/new/{id_article}', name: 'app_offre_new', methods: ['GET', 'POST'])] 
public function new(Request $request,  SluggerInterface $slugger, ArticleRepository $articleRepository, OffreRepository $offreRepository,int $id_article): Response
{
    $offres = [];
    if ($request->query->has('offres')) {
        $offres = unserialize(base64_decode($request->query->get('offres')));
    }

    $offre = new Offre();
    $form = $this->createForm(OffreType::class, $offre);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();

        // Gérer le téléchargement d'image
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('brochures_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }

            $offre->setImage($newFilename);
        }

        $offres[] = $offre;


        $entityManager = $this->getDoctrine()->getManager();

        foreach ($offres as $o) {
            if ($id_article) {
                $article = $articleRepository->find($id_article);
                $o->setArticle($article);
                $entityManager->persist($article);
            }
            $entityManager->persist($o);
        }
        
        $entityManager->flush();

        if ($form->isSubmitted() && $form->isValid()) {
          
            $entityManager->flush();
        
            $this->addFlash('success', 'Votre offre a été envoyée à l\'autre client" .');
        
            return $this->redirectToRoute('app_article_show', ['id' => $id_article], Response::HTTP_SEE_OTHER);
        }
        
        $this->addFlash('error', 'réessayer l\'offre n\'a pas été envoyée.');     
 
    }

    return $this->renderForm('offre/new.html.twig', [
        'form' => $form,
        'id_article' => $id_article,
    ]);
}



    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        $id_article = $offre->getArticle()->getIdArticle();
        $id = $offre->getIdOffre();
        $titre = $offre->getTitre();
        $produit_propose = $offre->getProduitPropose();
        $categorie = $offre->getCategorie();
        $sousCategorie = $offre->getSousCategorie();
        $marque = $offre->getMarque();
        $periodeUtilisation = $offre-> getPeriodeUtilisation();
        $etatpp = $offre->getEtatProduitPropose();
        $description = $offre->getDescription();
        $bonus = $offre->getBonus();
        $num_tel = $offre->getNumTel();
        $image = $offre->getImage();
    
        return $this->render('offre/show.html.twig', [
            'id_article' => $id_article,
            'id' => $id,
            'titre' => $titre,
            'produit_propose' => $produit_propose,
            'categorie' => $categorie,
            'sousCategorie' => $sousCategorie,
            'marque' => $marque,
            'periodeUtilisation' => $periodeUtilisation,
            'etatpp' => $etatpp,
            'description' => $description,
            'bonus' => $bonus,
            'num_tel' => $num_tel,
            'image' => $image,
        ]);
    }



    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {    
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $offreRepository->remove($offre, true);
        }

        return $this->redirectToRoute('app_mesarticles_show', ['id' => $offre->getArticle()->getIdArticle()], Response::HTTP_SEE_OTHER);
    }
}