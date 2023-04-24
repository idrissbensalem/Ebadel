<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idu =null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message:"Le champ CIN est obligatoire.")]
    private ?string $cin =null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message:"Le champ nom est obligatoire.")]
    #[Assert\Length(max:20, maxMessage:"Le nom ne peut pas dépasser {{ limit }} caractères")]
    private ?string  $nom =null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message:"Le champ prénom est obligatoire.")]
    #[Assert\Length(max:20, maxMessage:"Le prénom ne peut pas dépasser {{ limit }} caractères")]
    private ?string  $prenom=null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message:"Le champ téléphone est obligatoire.")]
    private ?string $tel =null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message:"Le champ email est obligatoire.")]
    #[Assert\Email(message:"L'email '{{ value }}' n'est pas valide.")]
    private ?string $email=null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message:"Le champ mot de passe est obligatoire.")]
    private ?string  $password=null;

    #[ORM\Column(type: 'string', nullable:true)]
    #[Assert\NotBlank(message:"L'image est obligatoire.")]
    private ?string $image = 'null';

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $role = 0;

    #[ORM\Column(type:"date", nullable:true)]
    private $datenaissance =null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Offre::class)]
    private Collection $offres;


    #[ORM\OneToMany(targetEntity: Message::class, mappedBy:"sender")]
    private $sentMessages;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy:"receiver")]
    private $receivedMessages;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(?int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
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

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticles(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setArticle($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticle() === $this) {
                $article->setArticle(null);
            }
        }

        return $this;
    }

    public function __construct()
    {
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
    }

    public function getSentMessages(): Collection
    {
        return $this->sentMessages;
    }

    public function addSentMessage(Message $sentMessage): self
    {
        if (!$this->sentMessages->contains($sentMessage)) {
            $this->sentMessages[] = $sentMessage;
            $sentMessage->setSender($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $sentMessage): self
    {
        if ($this->sentMessages->contains($sentMessage)) {
            $this->sentMessages->removeElement($sentMessage);
            // set the owning side to null (unless already changed)
            if ($sentMessage->getSender() === $this) {
                $sentMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $receivedMessage): self
    {
        if (!$this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages[] = $receivedMessage;
            $receivedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): self
    {
        if ($this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages->removeElement($receivedMessage);
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getReceiver() === $this) {
                $receivedMessage->setReceiver(null);
            }
        }

        return $this;
    }



}
