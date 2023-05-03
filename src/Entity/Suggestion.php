<?php

namespace App\Entity;

use App\Repository\SuggestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $suggC = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $suggS = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $suggM = null;
    #[ORM\Column(length: 255, nullable: true, options: ["default" => "non défini"])]
    private ?string $etatc;

    #[ORM\Column(length: 255, nullable: true, options: ["default" => "non défini"])]
    private ?string $etats;

    #[ORM\Column(length: 255, nullable: true, options: ["default" => "non défini"])]
    private ?string $etatm;


    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuggC(): ?string
    {
        return $this->suggC;
    }

    public function setSuggC(?string $suggC): self
    {
        $this->suggC = $suggC;

        return $this;
    }

    public function getSuggS(): ?string
    {
        return $this->suggS;
    }

    public function setSuggS(?string $suggS): self
    {
        $this->suggS = $suggS;

        return $this;
    }

    public function getSuggM(): ?string
    {
        return $this->suggM;
    }

    public function setSuggM(?string $suggM): self
    {
        $this->suggM = $suggM;

        return $this;
    }

    public function getEtatc(): ?string
    {
        return $this->etatc;
    }

    public function setEtatc(string $etatc): self
    {
        $this->etatc = $etatc;

        return $this;
    }

    public function getEtats(): ?string
    {
        return $this->etats;
    }

    public function setEtats(string $etats): self
    {
        $this->etats = $etats;

        return $this;
    }

    public function getEtatm(): ?string
    {
        return $this->etatm;
    }

    public function setEtatm(string $etatm): self
    {
        $this->etatm = $etatm;

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
}
