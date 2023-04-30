<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Response;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;

class ResponseController extends AbstractController
{
    //ajouter

        #[Route('/response/add/{id}', name: 'ajouter.response')]
     
      
    
    public function create(Request $request, ManagerRegistry $Doctrine, $id): HttpFoundationResponse
    {
        // trouver reclamation associée avec id
        $reclamation = $Doctrine->getRepository(Reclamation::class)->find($id);

       
        $response = new Response();

        $response->setReclamation($reclamation);

        $form = $this->createForm(ResponseType::class, $response);

       
        $form->handleRequest($request);

   
        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager = $Doctrine->getManager();
            $entityManager->persist($response);
            $entityManager->flush();

            
            return $this->redirectToRoute('listes.reclamations', ['id' => $id]);
        }

        
        return $this->render('response/add_reponse.html.twig', [
            'form' => $form->createView(),
            'reclamation' => $reclamation,
        ]);
    }

  //Affichage 
    #[Route('/response/{idreclamation}', name: 'list.responses')]
public function index(ManagerRegistry $Doctrine, $idreclamation): HttpFoundationResponse
{
    $reclamation = $Doctrine->getRepository(Reclamation::class)->find($idreclamation);
    $response = $Doctrine->getRepository(Response::class)->findOneBy([
        'reclamation' => $reclamation
    ]);

    return $this->render('response/index.html.twig', [
        'reclamation' => $reclamation,
        'response' => $response
    ]);
}
    


}