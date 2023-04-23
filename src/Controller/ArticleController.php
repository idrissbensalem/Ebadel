<?php

namespace App\Controller;

use App\Form\OffreType;
use App\Entity\Article;
use App\Entity\Offre;
use App\Controller\OffreController;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Google\Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;



#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  SluggerInterface $slugger , ArticleRepository $articleRepository, OffreRepository $offreRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
       
            $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('image')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $article->setImage($newFilename);
            }

            $articleRepository->save($article, true);
    
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);

        }
    
        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        $id = $article->getIdArticle();
        $nom = $article->getNomArticle();
        $categorie = $article->getCategorie();
        $sousCategorie = $article->getSousCategorie();
        $marque = $article->getMarque();
        $periodeUtilisation = $article-> getPeriodeUtilisation();
        $etat = $article->getEtat();
        $description = $article->getDescription();
        $image = $article->getImage();
    
        return $this->render('article/show.html.twig', [
            'id' => $id,
            'nom' => $nom,
            'categorie' => $categorie,
            'sousCategorie' => $sousCategorie,
            'marque' => $marque,
            'periodeUtilisation' => $periodeUtilisation,
            'etat' => $etat,
            'description' => $description,
            'image' => $image,
        ]);
    }
/*
    #[Route('/send-mail/{id}', name: 'app_send_mail', methods: ['GET'])]
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
       // $to = $request->request->get('to');
        //$subject = $request->request->get('subject');
        //$body = $request->request->get('body');
try{
        $email = (new Email())
            ->from('tn.ebadel@gmail.com')
            ->to('azaiez.allela@esprit.tn')
            ->subject('test')
            ->html('test');

        $mailer->send($email);
        return $this->json(['success' => true]);
    } catch (TransportExceptionInterface $e) {
        return $this->json(['error' => 'An error occurred while sending the email.']);
    }
}
*/

#[Route('/send-email', name: 'app_send_email')]
public function sendEmail(Client $googleClient): Response
{
    $service = new Google_Service_Gmail($googleClient);
    $message = new Google_Service_Gmail_Message();
    $email = 'tn.ebadel@gmail.com'; // use your own email address here
    $to = 'azaiez.allela@esprit.tn'; // use recipient's email address here
    $subject = 'Test Email';
    $body = 'This is a test email sent from Symfony using Gmail API.';
    $rawMessage = "To: $to\r\n" .
                  "Subject: $subject\r\n\r\n" .
                  "$body";
    $encodedMessage = rtrim(strtr(base64_encode($rawMessage), '+/', '-_'), '=');
    $message->setRaw($encodedMessage);
    $send = $service->users_messages->send($email, $message);
    if ($send) {
        return $this->json(['success' => true]);
    } else {
        return $this->json(['error' => 'An error occurred while sending the email.']);
}
    }
}
