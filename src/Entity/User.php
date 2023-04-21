<?php

namespace App\Entity;

use App\Entity\Jeux;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Participation::class)]
    private Collection $participations;

    #[ORM\ManyToMany(targetEntity: Jeux::class, inversedBy: 'users')]
    private Collection $jeux;

    #[ORM\OneToMany(mappedBy: 'gagnant', targetEntity: Jeux::class)]
    private Collection $jeuxGagnees;


    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->jeux = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jeux>
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeux $jeux): self
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux->add($jeux);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): self
    {
        $this->jeux->removeElement($jeux);

        return $this;
    }
    /**
     * @return Collection<int, Participation>
     */
    public function getJeuxGagnees(): Collection
    {
        return $this->jeuxGagnees;
    }

    public function addJeuxGagnee(Jeux $jeux): self
    {
        if (!$this->jeuxGagnees->contains($jeux)) {
            $this->jeuxGagnees->add($jeux);
            $jeux->setGagnant($this);
        }

        return $this;
    }

    public function removeJeuxGagnee(Jeux $jeux): self
    {
        if ($this->jeuxGagnees->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getGagnant() === $this) {
                $jeux->setGagnant(null);
            }
        }

        return $this;
    }


}
