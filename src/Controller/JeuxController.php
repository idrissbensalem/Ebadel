<?php

namespace App\Controller;

use App\Entity\Jeux;

use App\Entity\User;
use App\Form\JeuxType;
use App\Form\SearchJeuxType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JeuxRepository;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


#[Route('/adminJeu')]
class JeuxController extends AbstractController
{
    #[Route('/jeu', name: 'app_jeux_index', methods: [
        'GET', 'POST'
    ])]
    public function indexAdminJeu(Request $request2, Request $request, JeuxRepository $jeuxRepository): Response
    {

        $form = $this->createForm(SearchJeuxType::class);
        $search = $form->handleRequest($request2);

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Jeux::class)
            ->createQueryBuilder('u');

        //$desc= $jeuxRepository->findBy([],['date_jeux'=>'DESC']);
        $jeux  = new Paginator($query);
        $currentPage = $request->query->getInt('page', 1);

        $itemsPerPage = 3;
        $jeux


            ->getQuery()
            ->setFirstResult($itemsPerPage * ($currentPage - 1))
            ->setMaxResults($itemsPerPage);
        $totalItems = count($jeux);
        $pagesCount = ceil($totalItems / $itemsPerPage);
        if ($form->isSubmitted() && $form->isValid()) {
            $jeux =  $jeuxRepository->search($search->get('mots')->getData());
            // $jeux = new Paginator($jeuxRepository->findBy([], ['date_jeux' => 'DESC']));
            $currentPage = $request->query->getInt('page', 1);
            $totalItems = count($jeux);
            $pagesCount = ceil($totalItems / $itemsPerPage);
            return $this->render('jeux/index.html.twig', [
                'form' => $form->createView(),
                'jeux' => $jeux,

                'currentPage' => $currentPage,
                'pagesCount' => $pagesCount,
            ]);
        }
        return $this->render('jeux/index.html.twig', [
            'form' => $form->createView(),
            'jeux' => $jeux,
            //'desc' => $desc,
            'currentPage' => $currentPage,
            'pagesCount' => $pagesCount,


        ]);
    }

    #[Route('/new', name: 'app_jeux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, JeuxRepository $jeuxRepository): Response
    {
        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('image')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $jeux->setImage($newFilename);
            }

            $jeuxRepository->save($jeux, true);

            return $this->redirectToRoute('app_jeux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jeux/new.html.twig', [
            'jeux' => $jeux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jeux_show', methods: ['GET'])]
    public function show(Jeux $jeux): Response
    {
        return $this->render('jeux/show.html.twig', [
            'jeux' => $jeux,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_jeux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jeux $jeux, SluggerInterface $slugger, JeuxRepository $jeuxRepository): Response
    {
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('image')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $jeux->setImage($newFilename);
            }

            $jeuxRepository->save($jeux, true);

            return $this->redirectToRoute('app_jeux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jeux/edit.html.twig', [
            'jeux' => $jeux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jeux_delete', methods: ['POST'])]
    public function delete(Request $request, Jeux $jeux, JeuxRepository $jeuxRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jeux->getId(), $request->request->get('_token'))) {
            $jeuxRepository->remove($jeux, true);
        }

        return $this->redirectToRoute('app_jeux_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/spin/{id}', name: 'app_jeux_spin', methods: ['GET', 'POST'])]
    public function Spin(Request $request, Jeux $jeux, ParticipationRepository $participationRepository): Response
    {
        $participants = $participationRepository->getParticipantsByJeux($jeux);
        return $this->render('jeux/spin.html.twig', [
            'participants' => $participants,
            'jeux' => $jeux,
        ]);
    }
    #[Route('/gagner/{jeux}/{user}', name: 'app_jeux_gagner', options: ["expose" => true], methods: ['GET'])]
    public function Gagner(Jeux $jeux, User $user, JeuxRepository $jeuxRepository, EntityManagerInterface $em, MailerInterface $mailer): Response
    {

        $user->addJeuxGagnee($jeux);
        $jeux->setGagnant($user);
        $jeuxRepository->save($jeux, false);
        $em->persist($user);
        $em->flush();
        $email = (new TemplatedEmail())
            ->from('ahmed.chouchene@esprit.tn')
            ->to($user->getEmail())
            ->subject('EBADEL JEUXX')
            ->htmlTemplate('jeux/email_gagnant.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'jeux' => $jeux

            ]);

        $mailer->send($email);

        return $this->redirectToRoute('app_jeux_index', [], Response::HTTP_SEE_OTHER);
    }
}
