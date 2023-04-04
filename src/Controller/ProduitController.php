<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\BoutiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
 * @Route("/new/{boutiqueId}", name="app_produit_new", methods={"GET", "POST"})
 */
public function new(Request $request,  SluggerInterface $slugger, BoutiqueRepository $boutiqueRepository, ProduitRepository $produitRepository, int $boutiqueId = null): Response
{
    $produits = [];
    if ($request->query->has('produits')) {
        $produits = unserialize(base64_decode($request->query->get('produits')));
    }

    $produit = new Produit();
    $form = $this->createForm(ProduitType::class, $produit);

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

            $produit->setImage($newFilename);
        }

        $produits[] = $produit;

        if ($request->request->has('ajouter_autre_produit')) {
            return $this->redirectToRoute('app_produit_new', ['boutiqueId' => $boutiqueId, 'produits' => base64_encode(serialize($produits))], Response::HTTP_SEE_OTHER);
        }

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($produits as $p) {
            if ($boutiqueId) {
                $boutique = $boutiqueRepository->find($boutiqueId);
                $p->setBoutique($boutique);
                $entityManager->persist($boutique);
            }
            $entityManager->persist($p);
        }
        
        $entityManager->flush();

        return $this->redirectToRoute('app_boutique_show', ['id' => $produit->getBoutique()->getId()], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('produit/new.html.twig', [
        'form' => $form,
    ]);
}




    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, SluggerInterface $slugger): Response
{
    $form = $this->createForm(ProduitType::class, $produit);
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

            $produit->setImage($newFilename);
        }

        $produitRepository->save($produit, true);

        return $this->redirectToRoute('app_boutique_show', ['id' => $produit->getBoutique()->getId()], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('produit/edit.html.twig', [
        'produit' => $produit,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {    
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}