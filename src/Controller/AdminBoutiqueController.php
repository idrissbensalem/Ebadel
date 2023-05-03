<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Form\SearchBoutiqueType;
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
use Doctrine\ORM\Tools\Pagination\Paginator;

#[Route('/adminBoutique')]
class AdminBoutiqueController extends AbstractController
{
#[Route('/', name: 'app_boutique_admin_index', methods: ['GET','POST'])]
public function indexAdmin(Request $request2,   Request $request ,BoutiqueRepository $boutiqueRepository): Response
{
    $form = $this->createForm(SearchBoutiqueType::class);
        $search = $form->handleRequest($request2);

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Boutique::class)
            ->createQueryBuilder('u');

        //$desc= $boutiqueRepository->findBy([],['date_boutique'=>'DESC']);
        $boutiques  = new Paginator($query);
        $currentPage = $request->query->getInt('page', 1);

        $itemsPerPage = 3;
        $boutiques


            ->getQuery()
            ->setFirstResult($itemsPerPage * ($currentPage - 1))
            ->setMaxResults($itemsPerPage);
        $totalItems = count($boutiques);
        $pagesCount = ceil($totalItems / $itemsPerPage);
        if ($form->isSubmitted() && $form->isValid()) {
            $boutiques =  $boutiqueRepository->search($search->get('mots')->getData());
            // $boutiques = new Paginator($boutiqueRepository->findBy([], ['date_boutique' => 'DESC']));
            $currentPage = $request->query->getInt('page', 1);
            $totalItems = count($boutiques);
            $pagesCount = ceil($totalItems / $itemsPerPage);
            return $this->render('Admin/index.html.twig', [
                'form' => $form->createView(),
                'boutiques' => $boutiques,

                'currentPage' => $currentPage,
                'pagesCount' => $pagesCount,
            ]);
        }
        return $this->render('Admin/index.html.twig', [
            'form' => $form->createView(),
            'boutiques' => $boutiques,
            //'desc' => $desc,
            'currentPage' => $currentPage,
            'pagesCount' => $pagesCount,


        ]);

}
#[Route('/produit', name: 'app_produit_admin_index', methods: ['GET'])]
public function indexAdminProduit(ProduitRepository $produitRepository): Response
{
    $boutique = new Boutique();
return $this->render('Admin/indexProduit.html.twig', ['produits' => $produitRepository->findAll(),'boutique' => $boutique,]);
}
#[Route('/{id_produit}', name: 'app_produit_admin_delete', methods: ['POST'])]
public function delete(Request $request, $id_produit, ProduitRepository $produitRepository): Response
{
    $produit = $produitRepository->findProduitById($id_produit);

    if (!$produit) {
        throw $this->createNotFoundException('Produit not found');
    }

    if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
        $produitRepository->remove($produit, true);
    }

    return $this->redirectToRoute('app_produit_admin_index', [], Response::HTTP_SEE_OTHER);
}



#[Route('/{id}', name: 'app_boutique_admin_delete', methods: ['POST'])]
public function deleteBoutique(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
        $boutiqueRepository->remove($boutique, true);
    }

    return $this->redirectToRoute('app_boutique_admin_index', [], Response::HTTP_SEE_OTHER);
}
}