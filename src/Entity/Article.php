<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_article = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom de l'article est requis.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Le nom doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères',
    )]
    private ?string $nom_article = null;


    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "La période d'utilisation ne doit pas être vide.")]
    private ?string $periode_utilisation = null;


    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "L'état ne doit pas être vide.")]
    private ?string $etat = null;


    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'Votre description doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre description ne peut pas dépasser {{ limit }} caractères',
    )]
    private ?string $description = null;


    #[ORM\Column(type: 'string', nullable:true)]
    #[Assert\NotBlank(message:"L'image est obligatoire.")]
    private ?string $image = 'null';

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "Le champ marque est obligatoire.")]
    private ?string $marque;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "Le champ sous-catégorie est obligatoire.")]
    private ?string $sous_categorie;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: "Le champ catégorie est obligatoire.")]
    private ?string $categorie;

   
    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(name :'id', referencedColumnName :'id')]
     private ?User $user = null; 
    
    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Offre::class)]
    private Collection $offres;

    #[ORM\OneToMany(mappedBy: 'message', targetEntity: Offre::class)]
    private Collection $messages;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
     

    public function getIdArticle(): ?int
    {
        return $this->id_article;
    }

    public function getNomArticle(): ?string
    {
        return $this->nom_article;
    }

    public function setNomArticle(string $nomArticle): self
    {
        $this->nom_article = $nomArticle;

        return $this;
    }


    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getSousCategorie(): ?string
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(?string $sousCategorie): self
    {
        $this->sous_categorie = $sousCategorie;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getId(): ?User
    {
        return $this->id;
    }

    public function setIdu(?User $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPeriodeUtilisation(): ?string
    {
        return $this->periode_utilisation;
    }

    public function setPeriodeUtilisation(string $periodeUtilisation): self
    {
        $this->periode_utilisation = $periodeUtilisation;

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setOffre($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getOffre() === $this) {
                $offre->setOffre(null);
            }
        }

        return $this;
    }

    
    public function toString(): string
    {
        return $this->nom_article; // Remplacez "nom" par le nom de l'attribut que vous voulez afficher
    }

}
