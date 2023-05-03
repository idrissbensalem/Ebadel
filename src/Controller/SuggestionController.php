<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Suggestion;
use App\Form\SuggestionFormType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UserRepository;
use App\Repository\SuggestionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\TlsClientStream;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;




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
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtatc('Accepté');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmail($mailer, $suggestion);

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'La suggestion a été acceptée avec succès !']);
        return $this->redirectToRoute('suggestionList', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accepterSuggestionS/{id}', name: 'accepterSuggestionS')]
    public function accepterSuggestionS(SuggestionRepository $rep, $id): JsonResponse
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtats('Accepté');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmail($mailer, $suggestion);

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'La suggestion a été acceptée avec succès !']);
        return $this->redirectToRoute('suggestionListS', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accepterSuggestionM/{id}', name: 'accepterSuggestionM')]
    public function accepterSuggestionM(SuggestionRepository $rep, $id): JsonResponse
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtatm('Accepté');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmail($mailer, $suggestion);

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'La suggestion a été acceptée avec succès !']);
        return $this->redirectToRoute('suggestionListM', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/suggestionList', name: 'suggestionList')]
    public function suggestionList(SuggestionRepository $rep): Response
    {
        $suggestions = $rep->findAll();
        return $this->render('suggestion/afficherSugg.html.twig', [
            'suggestion' => $suggestions,
        ]);
    }
    #[Route('/suggestionListS', name: 'suggestionListS')]
    public function suggestionListS(SuggestionRepository $rep): Response
    {
        $suggestions = $rep->findAll();
        return $this->render('suggestion/afficherSuggS.html.twig', [
            'suggestion' => $suggestions,
        ]);
    }
    #[Route('/suggestionListM', name: 'suggestionListM')]
    public function suggestionListM(SuggestionRepository $rep): Response
    {
        $suggestions = $rep->findAll();
        return $this->render('suggestion/afficherSuggM.html.twig', [
            'suggestion' => $suggestions,
        ]);
    }

    #[Route('/Refusersuggestion/{id}', name: 'Refusersuggestion')]
    public function Refusersuggestion(SuggestionRepository $rep, $id): Response
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtatc('Refusé');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmailRefuse($mailer, $suggestion);

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'la suggestion a été refusée !']);
        return $this->redirectToRoute('suggestionList', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/RefusersuggestionS/{id}', name: 'RefusersuggestionS')]
    public function RefusersuggestionS(SuggestionRepository $rep, $id): Response
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtats('Refusé');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmailRefuse($mailer, $suggestion);;

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'la suggestion a été refusée !']);
        return $this->redirectToRoute('suggestionListS', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/RefusersuggestionM/{id}', name: 'RefusersuggestionM')]
    public function RefusersuggestionM(SuggestionRepository $rep, $id): Response
    {
        $suggestion = $rep->find($id);
        if (!$suggestion) {
            throw $this->createNotFoundException('Suggestion non trouvée pour l\'id ' . $id);
        }

        $suggestion->setEtatm('Refusé');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($suggestion);
        $entityManager->flush();

        $transport = new EsmtpTransport('smtp.gmail.com', 587);
        $transport->setUsername('tn.ebadel@gmail.com');
        $transport->setPassword('iixxcjrhvqhymado');
        $mailer = new Mailer($transport);
        $this->sendEmailRefuse($mailer, $suggestion);

        // renvoyer une réponse JSON pour indiquer que la suggestion a été acceptée
        return new JsonResponse(['message' => 'la suggestion a été refusée !']);
        return $this->redirectToRoute('suggestionListM', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/addSuggestion/{id_user?0}', name: 'addSuggestion')]
    public function addSuggestion(int $id_user, Request $request, UserRepository $rep, EntityManagerInterface $entityManager): Response
    {
        $sugg = new Suggestion();
        $user = $entityManager->getRepository(User::class)->find($id_user);
        $sugg->setUser($user);
        $form = $this->createForm(SuggestionFormType::class, $sugg);
        //$form->add("Envoyer",SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/suggestion/gpdfs', name: 'pdfs_suggestion')]
    public function generatePDFS(SuggestionRepository $rep): Response
    {
        // Récupérer toutes les suggestions de la base de données
        $suggestion = $rep->findAll();

        // Générer le code HTML de la page à partir du fichier twig
        $html =  $this->renderView('pdfS.html.twig', [
            'suggestion' => $suggestion,
        ]);

        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Charger le code HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Générer le PDF
        $dompdf->render();

        // Retourner une réponse avec le PDF en tant que contenu
        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdfS']
        );
    }


    #[Route('/suggestion/gpdfm', name: 'pdfm_suggestion')]

    public function generatePDFM(SuggestionRepository $rep): Response
    {

        $suggestion = $rep->findAll();
        $html =  $this->renderView('pdfM.html.twig', [
            'suggestion' => $suggestion,
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdfM']
        );
    }

    #[Route('/sendemail', name: 'app_send_email', methods: ['GET'])]
    public function sendEmail(MailerInterface $mailer, Suggestion $sugg)
    {
        // Adresse email de destination
        $to = $sugg->getUser()->getEmail();

        // Sujet du message
        $subject = 'suggestion acceptée!!';

        // Corps du message en HTML
        $body = "'<html><center><a href='https://ibb.co/gv67FFT'><img src='https://i.ibb.co/5Y29xx8/logo-removebg.png' height=20%;width=20%></a></center></html>"
            . "<html><center><h2>bienvenue sur notre site  Ebadel</h2> <br><h4>.. </h4></center></br></html>"
            . "<html><center><h3>Merci pour votre suggestion. Votre suggestion a été acceptée avec succès.</h3></center></html>";

        try {
            // Création d'un objet Email
            $email = (new Email())
                ->from('tn.ebadel@gmail.com') // Adresse email de l'expéditeur
                ->to($to) // Adresse email du destinataire
                ->subject($subject) // Sujet du message
                ->html($body); // Corps du message en HTML

            // Envoi de l'email avec le service Mailer
            $mailer->send($email);
            $response = new JsonResponse(['success' => true]); // Réponse JSON en cas de succès
        } catch (\Exception $e) {
            $response = new JsonResponse(['success' => false, 'message' => 'email could not be sent.']); // Réponse JSON en cas d'erreur
        }
    }



    #[Route('/sendemailRefuse', name: 'app_send_email', methods: ['GET'])]
    public function sendEmailRefuse(MailerInterface $mailer, Suggestion $sugg)
    {
        $to = $sugg->getUser()->getEmail();
        $subject = 'suggestion refusée!!';
        $body = "'<html><center><a href='https://ibb.co/gv67FFT'><img src='https://i.ibb.co/5Y29xx8/logo-removebg.png' height=20%;width=20%></a></center></html>"
            . "<html><center><h2>bienvenue sur notre site  Ebadel</h2> <br><h4>.. </h4></center></br></html>"
            . "<html><center><h3>Désolé, votre suggestion a été refusée.</h3></center></html>";

        try {
            $email = (new Email())
                ->from('tn.ebadel@gmail.com')
                ->to($to)
                ->subject($subject)
                ->html($body);

            $mailer->send($email);
            $response = new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            $response = new JsonResponse(['success' => false, 'message' => 'email could not be sent.']);
        }
    }
}
