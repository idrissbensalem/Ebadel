<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Suggestion;
use App\Form\SuggestionFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UserRepository;
use App\Repository\SuggestionRepository;

class SuggestionController extends AbstractController
{

    #[Route('/suggestionList', name: 'suggestionList')]
    public function suggestionList(SuggestionRepository $rep): Response
    {
        $suggestions = $rep ->findAll();
        return $this->render('suggestion/afficherSugg.html.twig', [
            'suggestion' => $suggestions,
        ]);
    }

    #[Route('/Refusersuggestion/{id}', name: 'Refusersuggestion')]
    public function Refusersuggestion(SuggestionRepository $rep, $id): Response
    {  
        $suggestion = $rep ->find(['idS' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($suggestion);
        $entityManager->flush();
        return $this->redirectToRoute('suggestionList');
    }

    #[Route('/addSuggestion', name: 'addSuggestion')]
    public function addSuggestion(Request $request,UserRepository $rep): Response
    {
        $sugg= new Suggestion();
        
        $form =$this->createForm(SuggestionFormType::class, $sugg);
        $form->add("Ajouter",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $entityManager = $this->getDoctrine()->getManager();
        $user=$rep->find(68);
        $sugg->setIdClient($user);
            $entityManager->persist($sugg);
            $entityManager->flush();
            return $this->redirectToRoute('app_suggestion');
    }
        return $this->render('suggestion/addSuggestion.html.twig', [
            'formSuggestion' =>  $form->createView(),
        ]);
    }
}
