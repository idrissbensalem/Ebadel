<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    //Affichage 
    #[Route('/review', name: 'list.review')]
    public function index(ReviewRepository $repo): Response
    {

        $reviews = $repo->findAll();
        $averageRating = $repo->getAverageRating();

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
            'average_rating' => $averageRating,
        ]);
    }
    //Ajouter Review
    #[Route('/review/add/{id?0}', name: 'ajouter.review')]
    public function AjouterReview(Review $review = null, ManagerRegistry $Doctrine, Request $request): Response

    { {

            $new = false;
            if (!$review) {
                $new = true;
                $review = new Review();
            }
            $form = $this->createForm(ReviewType::class, $review);



            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $Doctrine->getManager();
                $manager->persist($review);
                $manager->flush();
                if ($new) {
                    $message = "review a été ajouter avec success";
                } else {
                    $message = "review a été modifier avec success";
                }

                $this->addFlash(type: 'success', message: $message);


                return $this->redirectToRoute('app_article_show');
            } else {
                return $this->renderForm('review/add_review.html.twig', [
                    'form' => $form
                ]);
            }
        }
    }

    //delete
    #[Route('/delete/{id}', name: 'delete.review')]
    public function delete(Review $review = null, ManagerRegistry $Doctrine): RedirectResponse
    {

        if ($review) {
            $entityManager = $Doctrine->getManager();
            $entityManager->remove($review);
            $entityManager->flush();
            $this->addFlash(type: 'success', message: " votre avis a eté supprimé avec success");
        } else {
            $this->addFlash(type: 'error', message: " votre avis n'existe pas");
        }
        return $this->redirectToRoute('app_article_show');
    }


    #[Route('/reviews/{id}/like', name: 'review_like')]
    public function like(Review $review, ManagerRegistry $Doctrine)
    {

        $entityManager = $Doctrine->getManager();


        $review->setLikes($review->getLikes() + 1);

        $entityManager->persist($review);
        $entityManager->flush();

        return $this->redirectToRoute('app_article_show', ['id' => $review->getId()]);
    }


    #[Route('/reviews/{id}/dislike', name: 'review_dislike')]
    public function dislike(Review $review, ManagerRegistry $Doctrine)
    {

        $entityManager = $Doctrine->getManager();

        $review->setDislikes($review->getDislikes() + 1);


        $entityManager->persist($review);
        $entityManager->flush();

        return $this->redirectToRoute('app_article_show', ['id' => $review->getId()]);
    }
}
