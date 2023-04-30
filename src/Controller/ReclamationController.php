<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\FilterType;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Service\Mailing;
use App\Service\PdfService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateInterval;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('reclamation')]
class ReclamationController extends AbstractController
{
     //on peut aussi utiliser param converter
    #[Route('/{id<\d+>}',name:'reclamation.detail')]
    public function detailRec(ManagerRegistry $Doctrine, $id):Response{

        $repository=$Doctrine->getRepository(Reclamation::class);
        $reclamation=$repository->find($id);
     

        if(! $reclamation){
            $this->addFlash(type:'error',message:"this reclamation d'id $id doesn't exist ");
       
            return $this->redirectToRoute('list.reclamation');
        }
        return $this->render('reclamation/detail.html.twig',[
            'reclamation'=>$reclamation
        ]);


       }

    
    //Affichage
    #[Route('/',name:'list.reclamations')]
    public function index(ReclamationRepository $repo ,Request $request):Response{
     
        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() ) {
            $destinataire = $filterForm->get('destinataire')->getData();

            $reclamations = $repo->findByDestinataire($destinataire);
          
        } else {
            $reclamations=$repo->findAll(); 
           
           
        }
       

        $filteredReclamations = [];
        foreach ($reclamations as $reclamation) {
            if (!$reclamation->hasBadWord()) {
                $filteredReclamations[] = $reclamation;
            }
        }
    
        

    return $this->renderForm('reclamation/index.html.twig',[
        'reclamations'=>$reclamations,
        'filterForm'=>$filterForm

    ]);
    }


    //pdf
    #[Route('/pdf/{id}', name: 'reclamation.pdf')]
    public function generatePdfReclamation(Reclamation $reclamation = null, PdfService $pdf)
    {
        $html = $this->renderView('reclamation/detaille_reclamation.html.twig', [
            'reclamation' => $reclamation
        ]);   
        $pdf->showPdfFile($html);
    }

    ///find by contact
    #[Route('/condition/{bestcontact}',name:'list.reclamation')]
    public function byconatact(ManagerRegistry $Doctrine,$bestcontact,Request $request):Response{
 
     $repository =$Doctrine->getRepository(Reclamation::class);
     
     
     $filterForm = $this->createForm(FilterType::class);
     $filterForm->handleRequest($request);

     if ($filterForm->isSubmitted() ) {
         $destinataire = $filterForm->get('destinataire')->getData();

         $reclamations = $repository->findByDestinataire($destinataire);
       
     } else {
        $reclamations=$repository->bestcontact($bestcontact);
        
        
     }
    

     $filteredReclamations = [];
     foreach ($reclamations as $reclamation) {
         if (!$reclamation->hasBadWord()) {
             $filteredReclamations[] = $reclamation;
         }
     }
 


    return $this->render('reclamation/reclamation.html.twig',[
        'reclamations'=>$reclamations,
        'filterForm'=>$filterForm

    ]);
    }

    #[Route('/Alls/{page?1}/{nbre?3}',name:'listes.reclamations')]
     
    public function indesxAlls(ManagerRegistry $Doctrine, $page,$nbre,Request $request):Response{
        

        //récupérer repo
        $repository=$Doctrine->getRepository(Reclamation::class);
        //pagination
        $nbrReclamations = $repository->count([]);

        $nbrePages =ceil($nbrReclamations/$nbre);
      
        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() ) {
            $destinataire = $filterForm->get('destinataire')->getData();

            $reclamations = $repository->findByDestinataire($destinataire);
          
        } else {
            $reclamations =$repository->findBy([],[],limit:$nbre,offset:($page-1)*$nbre);
 
        }

        $filteredReclamations = [];
        foreach ($reclamations as $reclamation) {
            if (!$reclamation->hasBadWord()) {
                $filteredReclamations[] = $reclamation;
            }
        }

        return $this->renderForm('reclamation/index.html.twig',[
            'reclamations'=>$reclamations,
            'filterForm'=>$filterForm,
             'isPaginated'=>true,
             'nbrePages'=>$nbrePages,
             'page'=>$page,
             'nbre'=>$nbre
        ]);

    }
    


     //Ajout d'une reclamation

     #[Route('/ajouter/{id?0}', name: 'ajouter.reclamation')]
 
     public function addReclamation(Reclamation $reclamation = null, ManagerRegistry $doctrine, Request $request,Mailing $mailer ): Response 
     {
     $new = false;
     if (!$reclamation) {
         $new = true;
         $reclamation = new Reclamation();
     }
     
     $form = $this->createForm(ReclamationType::class, $reclamation);
     $form->remove('createdAt');

     $form->handleRequest($request);
     
 // Check  the reclamation 
if (!$new && $reclamation->getCreatedAt()) {
    $now = new DateTime();
    $createdAt = $reclamation->getCreatedAt();
    $interval = $createdAt->diff($now);
    if ($interval->h >= 4) { 
        $message = 'vous povez pas modifier cette reclamation apres 4 h.';
        return $this->render('reclamation/error.html.twig', [
            'message' => $message
        ]);
    }
}
     
     if ($form->isSubmitted() && $form->isValid()) {
         $manager = $doctrine->getManager();
         $manager->persist($reclamation);
         $manager->flush();
         
         if ($new) {
             $message = 'Reclamation ajoutée avec succès';
         } else {
             $message = 'Reclamation modifiée avec succès';
         }
 
         $mailmessage = $reclamation->getDestinataire().''.$message;
 
         
         $this->addFlash('success', $message);
         $mailer->sendEmail(content:$mailmessage);

         $user = $reclamation->getUser();
         $userId = $user ? $user->getId() : null;
         $redirectRoute = $userId ? $this->redirectToRoute('list.reclamation', ['bestcontact' => $userId]) : $this->redirectToRoute('home');
         return $redirectRoute;
     } else {
         return $this->renderForm('reclamation/add-form.html.twig', [
             'form' => $form
         ]);
        }
    
    }
     
  

    //delete
    #[Route('/delete/{id}',name:'delete.reclamation')]
    public function delete(Reclamation $reclamation=null,ManagerRegistry $Doctrine):RedirectResponse{

        if ($reclamation){
            $entityManager = $Doctrine->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
            $this->addFlash(type:'success',message:"la reclamation a eté supprimé avec success");
           
        }
        else{
            $this->addFlash(type:'error',message:"la reclamation n'existe pas");
            
        }
        return $this->redirectToRoute('listes.reclamations');
    }
     //update
    #[Route('/update/{id}/{contact}/{destinataire}/{type}/{status}/{description}/{response}',name:'updatereclamation')]
    public function update(ManagerRegistry $Doctrine, Reclamation $reclamation=null,$destinataire,$type,$status,$description){
         
        if($reclamation){
           
            $reclamation->setDestinataire($destinataire);
            $reclamation->setType($type);
         
            $reclamation->setDescription($description);
           
     
          $entityManager=$Doctrine->getManager();
          $entityManager->persist($reclamation);
          $entityManager->flush();
          $this->addFlash(type:'success',message:"la reclamation a eté modifie avec success");


        }
        else{
            $this->addFlash(type:'success',message:"la reclamation n'existe pas");


        }
        return $this->redirectToRoute('listes.reclamations');
    }

    //traitment reclamation
     #[Route('/{id}/traiter',name:'reclamation_traiter')]
     public function traiterReclamation(Reclamation $reclamation , ManagerRegistry $Doctrine, MailerInterface  $mailer): Response
     {
         $reclamation->setTreated(true);
     
         $entityManager=$Doctrine->getManager();
         $entityManager->persist($reclamation);
         $entityManager->flush();
     
         $email = (new TemplatedEmail())
         ->from('hassen.messaoudi@esprit.tn')
         ->to($reclamation->getUser()->getEmail())
         ->subject('Traitement')
         ->htmlTemplate('reclamation/email.html.twig');
         

    $mailer->send($email);
 
         return $this->redirectToRoute('listes.reclamations', ['id' => $reclamation->getId()]);
     }
     
    //untraitement

    #[Route('/{id}/untraiter',name:'reclamation_untraiter')]

    public function enCoursReclamation(Reclamation $reclamation, ManagerRegistry $Doctrine): Response
    {
        $reclamation->setTreated(false);
        
        $entityManager=$Doctrine->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();
        
        return $this->redirectToRoute('listes.reclamations', ['id' => $reclamation->getId()]);
    }

 }
 
// #Route

  //#[Route('/reclamation', name: 'app_reclamation')]
   // public function index(): Response
    //{
     //   return $this->render('reclamation/index.html.twig', [
           // 'controller_name' => 'ReclamationController',
     //   ]);
  //  }





  //ajoutttttt
    //Ajout d'une reclamation
    /**/
        



    /*  #[Route('/ajouter/{id?0}', name: 'ajouter.reclamation')]
     public function addReclamation(Reclamation $reclamation=null, ManagerRegistry $Doctrine,Request $request):Response 
     {
        
         $new=false;
        if(!$reclamation){   
         $new=true;
        $reclamation = new Reclamation();
          
        
        }
         $form =$this->createForm(ReclamationType::class,$reclamation);
         $form ->remove('createdAt');
         $form ->remove('user');
 
         $form->handleRequest($request);           
         
         if ($form->isSubmitted() && $form->isValid()){       
             $manager =$Doctrine->getManager();
             $manager->persist($reclamation);
             $manager->flush();
              if($new){
               $message="reclamation a été ajouter avec success";
               } else{
                 $message="reclamation a été modifier avec success";
               }
  
             $this->addFlash(type:'success',message:$message);
         
            
            return $this->redirectToRoute('list.reclamations');
         
    
         } else {
             return $this->render('reclamation/add-form.html.twig',[
                 'form'=>$form]);
           
         }
        
        
    }   */




    /*
    
     //Ajout d'une reclamation
    

    
    */ 