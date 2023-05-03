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
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateInterval;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/')]
class ReclamationUserController extends AbstractController
{


    //Ajout d'une reclamation

    #[Route('/reclamation/ajouter', name: 'ajouter_reclamation')]

    public function addReclamation(Reclamation $reclamation = null, ManagerRegistry $doctrine, Request $request, Mailing $mailer): Response
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

            $mailmessage = $reclamation->getDestinataire() . '' . $message;


            $this->addFlash('success', $message);
            $mailer->sendEmail(content: $mailmessage);

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

    ///find by contact
    #[Route('/reclamation/condition/{bestcontact}', name: 'list.reclamation')]
    public function byconatact(ManagerRegistry $Doctrine, $bestcontact, Request $request): Response
    {

        $repository = $Doctrine->getRepository(Reclamation::class);


        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            $destinataire = $filterForm->get('destinataire')->getData();

            $reclamations = $repository->findByDestinataire($destinataire);
        } else {
            $reclamations = $repository->bestcontact($bestcontact);
        }


        $filteredReclamations = [];
        foreach ($reclamations as $reclamation) {
            if (!$reclamation->hasBadWord()) {
                $filteredReclamations[] = $reclamation;
            }
        }



        return $this->render('reclamation/reclamation.html.twig', [
            'reclamations' => $reclamations,
            'filterForm' => $filterForm

        ]);
    }

    //delete
    #[Route('/reclamation/delete/{id}', name: 'delete_reclamation')]
    public function delete(Reclamation $reclamation = null, ManagerRegistry $Doctrine, $bestcontact): RedirectResponse
    {

        if ($reclamation) {
            $entityManager = $Doctrine->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
            $this->addFlash(type: 'success', message: "la reclamation a eté supprimé avec success");
        } else {
            $this->addFlash(type: 'error', message: "la reclamation n'existe pas");
        }
        return $this->redirectToRoute('list.reclamation', ['bestcontact' => $bestcontact]);
    }
}
