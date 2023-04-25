<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\User;
use App\Entity\Participation;

use App\Form\JeuxType;
use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/user')]
class JeuxUserController extends AbstractController
{
    #[Route('/', name: 'app_user_user', methods: ['GET', 'POST'])]
    public function selectuser(Request $request): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $form = $this->createFormBuilder()
            ->add('user', ChoiceType::class, [
                'choices' => $users,
                'choice_label' => function($user) {
                    return $user->getNom();
                },
                'placeholder' => 'Choose an user',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Select',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->get('user')->getData();
            return $this->redirectToRoute('app_user_jeux_index', ['id' => $user->getId()]);
        }

        return $this->render('JeuxUser/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_jeux_index', methods: ['GET'])]
    public function index(Request $request, JeuxRepository $jeuxRepository, $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createFormBuilder()
            ->add('participate', SubmitType::class, [
                'label' => 'Participer',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participation = new Participation();
            $participation->setUser($user);
            $participation->setJeux($jeux);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_jeux_index', ['id' => $user->getId()]);
        }

        return $this->render('JeuxUser/index.html.twig', [
            'jeux' => $jeuxRepository->findAll(),
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}/participate/{jeuxId}', name: 'app_user_participate')]
    public function participate(int $id, int $jeuxId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Récupérer l'utilisateur et le jeu à partir de leurs ID
        $user = $entityManager->getRepository(User::class)->find($id);
        $jeux = $entityManager->getRepository(Jeux::class)->find($jeuxId);

        // Vérifier que l'utilisateur et le jeu existent
        if (!$user || !$jeux) {
            throw $this->createNotFoundException('Unable to find User or Jeux entity.');
        }

        // Créer une nouvelle participation
        $participation = new Participation();
        $participation->setUser($user);
        $participation->setJeux($jeux);

        // Ajouter la participation à la base de données
        $entityManager->persist($participation);
        $entityManager->flush();
        $this->addFlash('success', 'You have successfully participated!');

        return $this->redirectToRoute('app_user_jeux_index', ['id' => $id]);
    }
    

}
