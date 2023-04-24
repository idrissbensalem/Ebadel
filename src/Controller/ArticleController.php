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
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\TlsClientStream;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;



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
            $transport = new EsmtpTransport('smtp.gmail.com', 587);
            $transport->setUsername('tn.ebadel@gmail.com');
            $transport->setPassword('iixxcjrhvqhymado');
            $mailer = new Mailer($transport);
            $this->sendEmailAjouterArticle($mailer , $article);
    
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
    
    
    #[Route('/sendemail/{id}', name: 'app_send_email', methods: ['GET'])]
    public function sendEmailAjouterArticle(MailerInterface $mailer ,Article $article):Response
    {
        $to = 'allala.azaiz@gmail.com';
        $subject = "Votre Article est ajouté avec succès !!";
        $body = "<html><center><a href='https://ibb.co/gv67FFT'><img src='https://i.ibb.co/5Y29xx8/logo-removebg.png' height=20%;width=20%></a></center></html>"
        . "<html><center><h2>bienvenue sur notre site  Ebadel</h2> <br><h4>donner une seconde vie a vos article ! au lieu de le jetter </h4></center></br></html>"
        . "<html><center><h2>Votre Article de nom : {$article->getNomArticle()} est ajouté avec succès</h2></center></html>";
        try {
            $email = (new Email())
                ->from('tn.ebadel@gmail.com')
                ->to($to)
                ->subject($subject)
                ->html($body);
    
            $mailer->send($email);
            $response = new JsonResponse(['success' => true]);
        }  catch (\Exception $e) {
            $response = new JsonResponse(['success' => false, 'message' => 'email could not be sent.']);
        }
    
        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
    

