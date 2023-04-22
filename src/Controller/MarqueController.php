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
use App\Form\MarqueType;

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
    #[Route('/SupprimerMarque/{nom}/{idm}', name: 'SupprimerMarque')]
    public function SupprimerMarque(MarqueRepository $rep, $nom,$idm): Response
    {  
        $marque = $rep ->find(['nomM' => $nom,'idM'=>$idm]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($marque);
        $entityManager->flush();
        return $this->redirectToRoute('marqueList');
    }


    #[Route('/modifierMarque/{nom}/{idm}', name: 'modifierMarque')]
    public function modifierMarque(Request $request,MarqueRepository $rep, $nom,$idm): Response
    {
        $marque = $rep ->find(['nomM' => $nom,'idM'=>$idm]);
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

    #[Route('/ajoutMarque', name: 'ajoutMarque')]
    public function ajoutMarque(Request $request,MarqueRepository $rep): Response
    {
        $marque = new Marque();
        $form =$this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $marque->setIdM(0);
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
