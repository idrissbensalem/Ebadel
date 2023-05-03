<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Index(name: 'boutique', columns: ['nom', 'ville'], flags: ['fulltext'])]

#[ORM\Entity(repositoryClass: BoutiqueRepository::class)]
class Boutique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom is required.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your name must be at least {{ limit }} characters long',
        maxMessage: 'Your  name cannot be longer than {{ limit }} characters',
    )]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', nullable:true)]
    #[Assert\NotBlank(message:"L'image est obligatoire.")]
    private ?string $image = 'null';

    // #[ORM\Column(length: 255)]
    // #[Assert\NotBlank(message:"Email is required.")]
    // //#[Assert\Email(message:" The Email '{{ value }}' is not a valid email. ")]
    // private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"lien is required.")]
    private ?string $lien = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'Your description must be at least {{ limit }} characters long',
        maxMessage: 'Your description cannot be longer than {{ limit }} characters',
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"num_telephone is required.")]
    //#[Assert\Length(min:8,max:8,minMessage:" Votre Num Telefone est invalide. ")]
    private ?int $num_telephone = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"num_fixe is required.")]
    //#[Assert\Length(min:8,max:8,minMessage:" Votre Num fix est invalide. ")]
    private ?int $num_fixe = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"gouvernorat is required.")]
    private ?string $gouvernorat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"ville is required.")]
    private ?string $ville = null;

    #[ORM\OneToMany(mappedBy: 'boutique', targetEntity: Produit::class)]
    private Collection $produits;

     #[ORM\ManyToOne(inversedBy: 'boutiques')]
     private ?User $user = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
       
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    // public function getEmail(): ?string
    // {
    //     return $this->email;
    // }

    // public function setEmail(string $email): self
    // {
    //     $this->email = $email;

    //     return $this;
    // }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

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

    public function getNumTelephone(): ?int
    {
        return $this->num_telephone;
    }

    public function setNumTelephone(int $num_telephone): self
    {
        $this->num_telephone = $num_telephone;

        return $this;
    }

    public function getNumFixe(): ?int
    {
        return $this->num_fixe;
    }

    public function setNumFixe(int $num_fixe): self
    {
        $this->num_fixe = $num_fixe;

        return $this;
    }

    public function getGouvernorat(): ?string
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(string $gouvernorat): self
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setBoutique($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getBoutique() === $this) {
                $produit->setBoutique(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->nom; // Remplacez "nom" par le nom de l'attribut que vous voulez afficher
    }

}