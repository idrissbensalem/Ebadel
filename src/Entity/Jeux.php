<?php

namespace App\Entity;
use App\Entity\User;
use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Index(name: 'jeux', columns: ['titre', 'type'], flags: ['fulltext'])]

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"title is required.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your title must be at least {{ limit }} characters long',
        maxMessage: 'Your  title cannot be longer than {{ limit }} characters',
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
   
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual("today", message:"The date must be equal or greater than today.")]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Expression(
        "this.getDateFin() >= this.getDateDebut()",
        message: "The end date must be greater than or equal to the start date"
    )]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"produit is required.")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Your product must be at least {{ limit }} characters long',
        maxMessage: 'Your  product cannot be longer than {{ limit }} characters',
    )]
    private ?string $produit = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"price is required.")]
    #[Assert\GreaterThan(value:0, message:"Le prix doit etre supérieur à zéro.")]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'jeux', targetEntity: Participation::class)]
    private Collection $participations;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'jeux')]
    private Collection $users;
    #[ORM\ManyToOne(inversedBy: 'jeuxGagnees', fetch:"EAGER")]
    private User $gagnant;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setJeux($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getJeux() === $this) {
                $participation->setJeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addJeux($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeJeux($this);
        }

        return $this;
    }
    public function getGagnant(): ?User
    {
        return $this->gagnant;
    }

    public function setGagnant(User $gagnant): self
    {
        $this->gagnant = $gagnant;

        return $this;
    }
}
