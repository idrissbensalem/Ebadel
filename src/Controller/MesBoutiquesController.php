<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Entity\Boutique;
use App\Entity\Produit;
use App\Controller\ProduitController;
use App\Entity\User;
use App\Form\BoutiqueType;
use App\Repository\BoutiqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



#[Route('/mesBoutique')]
class MesBoutiquesController extends AbstractController
{
    #[Route('/{id_user}', name: 'app_mesBoutiques_index', methods: ['GET'])]
    public function index(int $id_user,BoutiqueRepository $boutiqueRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id_user);
        $mesboutiques = $boutiqueRepository->findAll();
        $mesboutiques = $user->getBoutiques();
        
        return $this->render('mes_boutiques/index.html.twig', [
            'mesboutiques' => $mesboutiques,
        ]);
    }
    
    #[Route('/new/{id_user}', name: 'app_mesBoutiques_new', methods: ['GET', 'POST'])]
    public function new(int $id_user,Request $request,  SluggerInterface $slugger ,EntityManagerInterface $entityManager, BoutiqueRepository $boutiqueRepository, ProduitRepository $produitRepository): Response
    {
        $boutique = new Boutique();
        $user = $entityManager->getRepository(User::class)->find($id_user);
        $boutique ->setUser($user);
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
    

    #[Route('/show/{id}', name: 'app_mesboutique_show', methods: ['GET'])]
    public function show(Boutique $boutique): Response
    {
        $produits = $boutique->getProduits();
        return $this->render('boutique/show.html.twig', [
            'produits' => $produits,
            'boutique' => $boutique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mesBoutiques_edit', methods: ['GET', 'POST'])]
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
    
            return $this->redirectToRoute('app_mesBoutiques_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mesBoutiques_delete', methods: ['POST'])]
    public function delete(Request $request, Boutique $boutique, BoutiqueRepository $boutiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
            $boutiqueRepository->remove($boutique, true);
        }

        return $this->redirectToRoute('app_mesBoutiques_index', [], Response::HTTP_SEE_OTHER);
    }
}