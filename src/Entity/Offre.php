<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id_offre = null;
    
    
        #[ORM\Column(length: 255)]
        #[Assert\NotBlank(message:"Le titre est requis.")]
        #[Assert\Length(
            min: 3,
            max: 50,
            minMessage: 'Le titre doit comporter au moins {{ limit }} caractères',
            maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères',
        )]
        private ?string $titre = null;

        #[ORM\Column(type: 'string', length: 50)]
        #[Assert\NotBlank(message: "Le produit proposé ne doit pas être vide.")]
        private ?string $produit_propose = null;
    
    
        #[ORM\Column(type: 'string', length: 50)]
        #[Assert\NotBlank(message: "La période d'utilisation ne doit pas être vide.")]
        private ?string $periode_utilisation = null;
    
    
        #[ORM\Column(type: 'string', length: 50)]
        #[Assert\NotBlank(message: "L'état ne doit pas être vide.")]
        private ?string $etat_produit_propose = null;
    
    
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
    
 
    
      
    
       

        #[ORM\Column(type: 'string', length: 100 , nullable:true)]
        private ?string $bonus = null;

        
        #[ORM\Column(type :'integer')]
        #[Assert\NotBlank(message :'Le numéro de téléphone est obligatoire.')]
        #[Assert\Positive(message :'Le numéro de téléphone doit être un nombre positif.')]
        #[Assert\Length(min :8, minMessage :'Le numéro de téléphone doit contenir au moins 8 chiffres.')]
        private ?int $num_tel =null;

        #[ORM\ManyToOne(inversedBy: 'offres')]
        #[ORM\JoinColumn(name :'id', referencedColumnName :'id')]
         private ?User $user = null;  

        #[ORM\ManyToOne(inversedBy: 'offres')]
        #[ORM\JoinColumn(name :'id_article', referencedColumnName :'id_article')]
        private ?Article $article = null;
   
        #[ORM\ManyToOne(inversedBy: 'offres')]
        private ?Categorie $categorie = null;
    
        #[ORM\ManyToOne(inversedBy: 'offres')]
        private ?Marque $marque = null;
    
        #[ORM\ManyToOne(inversedBy: 'offres')]
        private ?Souscategorie $sousCategorie = null;
    

        
     
       public function getArticle(): ?Article
       {
           return $this->article;
       }
   
       public function setArticle(?Article $article): self
       {
           $this->article = $article;
   
           return $this;
       }
        
    public function getIdOffre(): ?int
    {
        return $this->id_offre;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    


    public function getProduitPropose(): ?string
    {
        return $this->produit_propose;
    }

    public function setProduitPropose(string $produitPropose): self
    {
        $this->produit_propose = $produitPropose;

        return $this;
    }

    public function getPeriodeUtilisation(): ?string
    {
        return $this->periode_utilisation;
    }

    public function setPeriodeUtilisation(string $periode_utilisation): self
    {
        $this->periode_utilisation = $periode_utilisation;

        return $this;
    }

    public function getEtatProduitPropose(): ?string
    {
        return $this->etat_produit_propose;
    }

    public function setEtatProduitPropose(string $etatProduitPropose): self
    {
        $this->etat_produit_propose = $etatProduitPropose;

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

    public function getBonus(): ?string
    {
        return $this->bonus;
    }

    public function setBonus(?string $bonus): self
    {
        $this->bonus = $bonus;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $numTel): self
    {
        $this->num_tel = $numTel;

        return $this;
    }

    public function getId(): ?User
    {
        return $this->id_offre;
    }

    public function setId(?User $id): self
    {
        $this->id_offre = $id;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getSousCategorie(): ?Souscategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?Souscategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

}
