<?php

namespace App\Entity;

use App\Controller\ReclamationController;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    /**
     * @Assert\Range(min=1 , max=5)
    */
    private ?int $rate = null;
      /**
     * @Assert\NotBlank(message="remplir ce champ")
    */
    #[Assert\Length(
        min: 2,
        max: 15,
        minMessage: 'Votre avis doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre avis ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: "article_id", referencedColumnName: "id_article",onDelete: 'CASCADE')]
    private ?Article $article = null;
    

    #[ORM\Column(nullable: true)]
    private ?int $likes = null;

    #[ORM\Column(nullable: true)]
    private ?int $dislikes = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get the rating message for the review based on its rating.
     *
     * @return string
     */
    public function getRatingMessage(): string
    {
        if ($this->rate <= 2) {
            return 'Bad review';
        } elseif ($this->rate <= 4) {
            return 'Average review';
        } else {
            return 'Excellent review';
        }
    }

    /**
     * Calculate the average rating for all reviews.
     *
     * @param array $reviews
     *
     * @return float
     */
    public static function calculateAverageRating(array $reviews): float
    {
        $totalRating = 0;
        $numReviews = 0;
        
        foreach ($reviews as $review) {
            $totalRating += $review->getRating();
            $numReviews++;
        }
        
        if ($numReviews > 0) {
            return $totalRating / $numReviews;
        } else {
            return 0;
        }
    }

    /**
     * Get the rating message for all reviews based on their average rating.
     *
     * @param array $reviews
     *
     * @return string
     */
    public static function getRatingMessageForAllReviews(array $reviews): string
    {
        $averageRating = self::calculateAverageRating($reviews);
        
        if ($averageRating <= 2) {
            return 'Bad product';
        } elseif ($averageRating <= 4) {
            return 'Average product';
        } else {
            return 'Excellent product';
        }
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(?int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    public function like()
    {
        $this->likes++;
    }

    public function dislike()
    {
        $this->dislikes++;
    }

   
    public function __ToString(): string
    {
       
        $this->rate;
        $this->comment;
        
        return $this;

    }
   

}
