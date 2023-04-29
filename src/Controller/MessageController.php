<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use App\Form\MessageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/message')]
class MessageController extends AbstractController
{
    #[Route('/{id_user}', name: 'app_message_index', methods: ['GET'])]
    public function index(int $id_user): Response
    {
       // $user = $this->getUser();
       $user = $this->getDoctrine()->getRepository(User::class)->find($id_user);

        // get all messages received by the user
        $receivedMessages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findByReceiver($user);

        // get all messages sent by the user
        $sentMessages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBySender($user);

        return $this->render('message/index.html.twig', [
            'receivedMessages' => $receivedMessages,
            'sentMessages' => $sentMessages,
        ]);
    }

    #[Route('/message/new/{recipient}/{article}', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, User $recipient ,Article $article): Response
    {
        $message = new Message();
        $message->setSender($this->getUser());
        //$message->setSender($recipient);
        $message->setReceiver($recipient);
        $message->setArticle($article);
        $message->setTimestamp(new DateTimeImmutable());

        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

         return $this->redirectToRoute('app_article_show', ['id' => $article->getIdArticle()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'id' => $article->getIdArticle(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/message/new/{recipient}/{article}/{message}', name: 'app_reponse_new', methods: ['GET', 'POST'])]
    public function newReponse(Request $request, User $recipient ,Article $article, Message $message): Response
    {
        $message_reponse = new Message();
        //$message->setSender($this->getUser());
        $message_reponse->setSender($recipient);
        $message_reponse->setReceiver($recipient);
        $message_reponse->setArticle($article);
        $message_reponse->setTimestamp(new DateTimeImmutable());

        $form = $this->createForm(MessageFormType::class, $message_reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message_reponse);
            $entityManager->flush();

         return $this->redirectToRoute('app_message_show', ['id' => $message->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/reponse.html.twig', [
            'message' => $message_reponse,
            'id' => $article->getIdArticle(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/message/{id}}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        $idmessage = $message->getId();
        $iduser = $message->getSender()->getId();
        $id_article = $message->getArticle()->getIdArticle();
        $nomArticle = $message->getArticle()->getNomArticle();
        $NomSender = $message->getSender()->getNom();
        $PrenomSender = $message->getSender()->getPrenom();
        $objet = $message->getObjet();
        $content = $message->getContent();
        $time = $message->getTimestamp()->getTimestamp();
        $time_string = date('Y-m-d H:i:s', $time);
        

        return $this->render('message/show.html.twig', [
            'idmessage' =>$idmessage,
            'iduser' =>$iduser,
            'id_article' =>$id_article,
            'nomArticle' =>$nomArticle,
            'NomSender' => $NomSender,
            'PrenomSender' => $PrenomSender,
            'objet' => $objet,
            'content' => $content,
            'time' => $time_string,
        ]);
    }

    #[Route('/message/{id}/delete', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_index');
    }
}