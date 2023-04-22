<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Form\CategorieFormType;
use Symfony\Component\Console\Output\ConsoleOutput;

class CategorieController extends AbstractController
{
    #[Route('/categorieList', name: 'categorieList')]
    public function categorieList(CategorieRepository $rep): Response
    {
        $categories = $rep ->findAll();
        return $this->render('categorie/index.html.twig', [
            'categorie' => $categories,
        ]);
    }
    #[Route('/SupprimerCategorie/{nom}', name: 'SupprimerCategorie')]
    public function SupprimerCategorie(CategorieRepository $rep, $nom): Response
    {  
        $categorie = $rep ->find(['nomC' => $nom]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('categorieList');
    }
    #[Route('/modifierCategorie/{nom}', name: 'modifierCategorie')]
    public function modifierCategorie(Request $request,CategorieRepository $rep, $nom): Response
    {
        $categorie = $rep ->find(['nomC' => $nom]);
        $form =$this->createForm(CategorieFormType::class, $categorie);
//$form->add("Modifier",SubmitType::class);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('categorieList');
}
        return $this->render('categorie/ModifierCategorie.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }

    #[Route('/ajoutCategorie', name: 'ajoutCategorie')]
    public function ajoutCategorie(Request $request,CategorieRepository $rep): Response
    {
        $categorie = new Categorie();
        $form =$this->createForm(CategorieFormType::class, $categorie);
    //$form->add("Ajouter",SubmitType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
    $entityManager = $this->getDoctrine()->getManager();
    $categorie->setIdC(0);
        $entityManager->persist($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('categorieList');
}
        return $this->render('categorie/AjoutCategorie.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }
}
