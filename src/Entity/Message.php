<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:"sentMessages")]
    #[ORM\JoinColumn(name :'idu_sender', referencedColumnName :'id' ,nullable:false)]
    #[Assert\NotBlank]
    private $sender;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:"receivedMessages")]
    #[ORM\JoinColumn(name :'idu_receiver', referencedColumnName :'id' ,nullable:false)]
    #[Assert\NotBlank]
    private $receiver;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(name :'id_article', referencedColumnName :'id_article')]
    private ?Article $article = null;

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank(message:"L'objet de message est requis.")]
    private $objet;

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank(message:"Le contenu du message ne peut pas être vide.")]
    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: 'Le nom doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères',
    )]
    private $content;

    #[ORM\Column(type:"datetime")]
    #[Assert\NotNull]
    private $timestamp;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
