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



#[Route('/boutique')]
class BoutiqueController extends AbstractController
{
    #[Route('/', name: 'app_boutique_index', methods: ['GET'])]
    public function index(BoutiqueRepository $boutiqueRepository): Response
    {
        return $this->render('boutique/index.html.twig', [
            'boutiques' => $boutiqueRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_boutique_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  SluggerInterface $slugger , BoutiqueRepository $boutiqueRepository, ProduitRepository $produitRepository): Response
    {
        $boutique = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $boutique);
       
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

                $boutique->setImage($newFilename);
            }

            $boutiqueRepository->save($boutique, true);
    
            return $this->redirectToRoute('app_produit_new', ['boutiqueId' => $boutique->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('boutique/new.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_boutique_show', methods: ['GET'])]
    public function show(Boutique $boutique): Response
    {
        $produits = $boutique->getProduits();
        return $this->render('boutique/show.html.twig', [
            'produits' => $produits,
            'boutique' => $boutique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boutique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(BoutiqueType::class, $boutique);
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
    
                $boutique->setImage($newFilename);
            }
    
            $boutiqueRepository->save($boutique, true);
    
            return $this->redirectToRoute('app_boutique_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boutique_delete', methods: ['POST'])]
    public function delete(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
            $boutiqueRepository->remove($boutique, true);
        }

        return $this->redirectToRoute('app_boutique_index', [], Response::HTTP_SEE_OTHER);
    }
}