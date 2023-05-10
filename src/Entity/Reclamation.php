<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
     
    
   

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $destinataire = null;

    
     
    #[Assert\Length(
        min: 20,
        max: 100,
        minMessage: 'Votre description doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre description ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $description = null;
     
   
    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?User $user = null;
    

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    //@Gedmo\Timestampable(no="create)
    private $createdAt;

    #[ORM\Column]
    private ?bool $treated = false;

    #[ORM\OneToMany(mappedBy: 'reclamation' ,targetEntity: Response::class,cascade: ['persist'])]

    private Collection $responses;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->responses = new ArrayCollection();
        
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

    public function getDestinataire(): ?string
    {
        return $this->destinataire;
    }

    public function setDestinataire(string $destinataire): self
    {
        $this->destinataire = $destinataire;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function hasBadWord(): bool
    {
        // Define an array of bad words
        $badWords = ['badword1 hahc azjczajnd qdhqncq zfnioncqs azdjnjzq c', 'badword2', 'badword3'];
        
        // Check if the description contains any of the bad words
        foreach ($badWords as $badWord) {
            if (stripos($this->getDescription(), $badWord) !== false) {
                return true;
            }
        }
        
        return false;
    }

    public function isTreated(): ?bool
    {
        return $this->treated;
    }

    public function setTreated(bool $treated): self
    {
        $this->treated = $treated;

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setReclamation($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getReclamation() === $this) {
                $response->setReclamation(null);
            }
        }

        return $this;
    }
    
}
