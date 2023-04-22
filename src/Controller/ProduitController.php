<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $rep,CategorieRepository $repC): Response
    {
        $categories=$repC->findAll();
        $produits=$rep->findAll();
        return $this->render('produit/ListeProduits.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/{marque}/{sousCateg}', name: 'getByMarque')]
    public function getByMarque(ProduitRepository $rep ,CategorieRepository $repC,$marque,$sousCateg): Response
    {
        
        $produits=$rep->findBy(['nomM' => $marque,'nomSC'=>$sousCateg]);
        $categories=$repC->findAll();
        return $this->render('produit/ListeProduits.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }
}
