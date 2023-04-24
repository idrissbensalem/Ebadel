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
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;



class SuggestionController extends AbstractController
{
    #[Route('/suggestion', name: 'suggestion')]
    public function suggestion(SuggestionRepository $rep): Response
    {

        return $this->render('suggestion/index.html.twig');
    }

    #[Route('/accepterSuggestion/{id}', name: 'accepterSuggestion')]
    public function accepterSuggestion(SuggestionRepository $rep, $id): JsonResponse
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id '.$id);
        }
        
        $suggestion->setEtatc('Accepté');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();
    
        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'La suggestion a été acceptée avec succès !']);
    }
    

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
        $form->add("Envoyer",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $entityManager = $this->getDoctrine()->getManager();
        $user=$rep->find(68);
        $sugg->setIdClient($user);
            $entityManager->persist($sugg);
            $entityManager->flush();
            return $this->redirectToRoute('suggestion');
    }
        return $this->render('suggestion/addSuggestion.html.twig', [
            'formSuggestion' =>  $form->createView(),
        ]);
    }


    #[Route('/suggestion/gpdf', name: 'pdf_suggestion')]

    public function generatePDF(SuggestionRepository $rep): Response
    {
         
        $suggestion = $rep->findAll();
        $html =  $this->renderView('pdf.html.twig', [
            'suggestion' => $suggestion,
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
