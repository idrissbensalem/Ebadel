<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomC = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    private Collection $article;

  

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Souscategorie::class)]
    private Collection $souscategories;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Marque::class)]
    private Collection $marques;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->souscategories = new ArrayCollection();
        $this->marques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): self
    {
        $this->nomC = $nomC;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Souscategorie>
     */
    public function getSouscategories(): Collection
    {
        return $this->souscategories;
    }

    public function addSouscategory(Souscategorie $souscategory): self
    {
        if (!$this->souscategories->contains($souscategory)) {
            $this->souscategories->add($souscategory);
            $souscategory->setCategorie($this);
        }

        return $this;
    }

    public function removeSouscategory(Souscategorie $souscategory): self
    {
        if ($this->souscategories->removeElement($souscategory)) {
            // set the owning side to null (unless already changed)
            if ($souscategory->getCategorie() === $this) {
                $souscategory->setCategorie(null);
            }
        }

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
            $marque->setCategorie($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getCategorie() === $this) {
                $marque->setCategorie(null);
            }
        }

        return $this;
    }
}
