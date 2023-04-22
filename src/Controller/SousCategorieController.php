<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SousCategorieRepository;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Souscategorie;
use App\Form\SousCategorieFormType;

class SousCategorieController extends AbstractController
{
    #[Route('/sousCategorieList', name: 'sousCategorieList')]
    public function sousCategorieList(SousCategorieRepository $rep): Response
    {
        $SousCategories = $rep ->findAll();

        return $this->render('sous_categorie/index.html.twig', [
            'sousCategorie' => $SousCategories,
        ]);
    }
    #[Route('/SupprimerSCategorie/{nom}', name: 'SupprimerSCategorie')]
    public function SupprimerSCategorie(SousCategorieRepository $rep, $nom): Response
    {  
        $sousCategorie = $rep ->findOneBy(['nom_s_c' => $nom]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($sousCategorie);
        $entityManager->flush();
        return $this->redirectToRoute('sousCategorieList');
    }


    #[Route('/modifierSCategorie/{nom}', name: 'modifierSCategorie')]
    public function modifierSCategorie(Request $request,SousCategorieRepository $rep, $nom): Response
    {
        $sousCategorie = $rep ->findOneBy(['nom_s_c' => $nom]);
        $form =$this->createForm(SousCategorieFormType::class, $sousCategorie);
//$form->add("Modifier",SubmitType::class);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('sousCategorieList');
}
        return $this->render('sous_categorie/ModifierSCategorie.html.twig', [
            'formSCategorie' => $form->createView(),
        ]);
    }

    #[Route('/ajoutSCategorie', name: 'ajoutSCategorie')]
    public function ajoutSCategorie(Request $request,SousCategorieRepository $rep): Response
    {
        $sousCategorie = new Souscategorie();
        $form =$this->createForm(SousCategorieFormType::class, $sousCategorie);
//$form->add("Ajouter",SubmitType::class);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $entityManager = $this->getDoctrine()->getManager();
    $sousCategorie->setIdSC(0);
        $entityManager->persist($sousCategorie);
        $entityManager->flush();
        return $this->redirectToRoute('sousCategorieList');
}
        return $this->render('sous_categorie/AjoutSCategorie.html.twig', [
            'formSCategorie' => $form->createView(),
        ]);
    }
}
