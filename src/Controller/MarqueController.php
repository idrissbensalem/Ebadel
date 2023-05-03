<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MarqueRepository;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Marque;
use App\Entity\Souscategorie;
use App\Form\MarqueType;
use App\Repository\SouscategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

class MarqueController extends AbstractController
{
    #[Route('/marqueList', name: 'marqueList')]
    public function marqueList(MarqueRepository $rep): Response
    {
        $Marques = $rep ->findAll();
        return $this->render('marque/index.html.twig', [
            'marque' => $Marques,
        ]);
    }
    #[Route('/SupprimerMarque/{nom}', name: 'SupprimerMarque')]
    public function SupprimerMarque(MarqueRepository $rep, $nom): Response
    {  
        $marque = $rep ->findOneBy(['nomM' => $nom]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($marque);
        $entityManager->flush();
        return $this->redirectToRoute('marqueList');
    }


    #[Route('/modifierMarque/{nom}', name: 'modifierMarque')]
    public function modifierMarque(Request $request,MarqueRepository $rep, $nom): Response
    {
        $marque = $rep ->findOneBy(['nomM' => $nom]);
        $form =$this->createForm(MarqueType::class, $marque);
//$form->add("Modifier",SubmitType::class);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('marqueList');
}
        return $this->render('marque/ModifierMarque.html.twig', [
            'formMarque' => $form->createView(),
        ]);
    }

    #[Route('/ajoutMarque/{id}', name: 'ajoutMarque')]
    public function ajoutMarque( int $id ,Request $request,MarqueRepository $rep,EntityManagerInterface $entityManager , SouscategorieRepository $repoS): Response
    {
        
    
        $marque = new Marque();
        $form =$this->createForm(MarqueType::class, $marque);
        $cat = $entityManager->getRepository(Souscategorie::class)->find($id);
        $marque->setSouscategorie($cat);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                 $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($marque);
                $entityManager->flush();
        return $this->redirectToRoute('marqueList');
        }
        return $this->render('marque/AjoutMarque.html.twig', [
            'formMarque' => $form->createView(),

        ]);
    }
}
