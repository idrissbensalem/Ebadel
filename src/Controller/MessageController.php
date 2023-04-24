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
    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(): Response
    {
       // $user = $this->getUser();
       $user = $this->getDoctrine()->getRepository(User::class)->find(1);

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
       //$message->setSender($this->getUser());
        $message->setSender($recipient);
        $message->setReceiver($recipient);
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
            'form' => $form->createView(),
        ]);
    }

    #[Route('/message/{id}}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
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