<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Entity\Boutique;
use App\Entity\Produit;
use App\Controller\ProduitController;
use App\Form\BoutiqueType;
use App\Repository\BoutiqueRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin')]
class AdminBoutiqueController extends AbstractController
{
#[Route('/', name: 'app_boutique_admin_index', methods: ['GET'])]
public function indexAdmin(BoutiqueRepository $boutiqueRepository): Response
{
    return $this->render('Admin/index.html.twig', ['boutiques' => $boutiqueRepository->findAll(),]);
}
#[Route('/produit', name: 'app_produit_admin_index', methods: ['GET'])]
public function indexAdminProduit(ProduitRepository $produitRepository): Response
{
    $boutique = new Boutique();
return $this->render('Admin/indexProduit.html.twig', ['produits' => $produitRepository->findAll(),'boutique' => $boutique,]);
}
#[Route('/{id}', name: 'app_produit_admin_delete', methods: ['POST'])]
public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
{    
    if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
        $produitRepository->remove($produit, true);
    }

    return $this->redirectToRoute('app_produit_admin_index', [], Response::HTTP_SEE_OTHER);
}
}