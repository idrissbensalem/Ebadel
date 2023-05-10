<?php

namespace App\Entity;

use App\Repository\SouscategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SouscategorieRepository::class)]
class Souscategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_s_c = null;

    #[ORM\ManyToOne(inversedBy: 'souscategories')]
    #[ORM\JoinColumn(name: 'categorie_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Categorie $categorie = null;
    
    #[ORM\OneToMany(mappedBy: 'souscategorie', targetEntity: Marque::class)]
    private Collection $marques;
    
    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Article::class)]
private Collection $articles;

    public function __construct()
    {
        $this->marques = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSC(): ?string
    {
        return $this->nom_s_c;
    }
    public function getnom_s_c(): ?string
    {
        return $this->nom_s_c;
    }

    public function setNomSC(string $nom_s_c): self
    {
        $this->nom_s_c = $nom_s_c;

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

    /**
     * @return Collection<int, Marque>
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques->add($marque);
            $marque->setSouscategorie($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getSouscategorie() === $this) {
                $marque->setSouscategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setSousCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getSousCategorie() === $this) {
                $article->setSousCategorie(null);
            }
        }

        return $this;
    }
}
