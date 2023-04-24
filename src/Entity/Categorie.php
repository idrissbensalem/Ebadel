<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Categorie
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @UniqueEntity(fields="nomC",message="Le nom de la catégorie existe déja!")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idC;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @ORM\Id
     * @Assert\NotBlank(message="le nom de la catégorie ne doit pas étre vide")
     */
    #[Assert\Length(
        min: 2,
        minMessage: 'le nom de la catégorie doit comporter au moins {{ limit }} caractères',
    )]
    private $nomC;
    
    /**
     * @ORM\OneToMany(targetEntity="Souscategorie", mappedBy="nomC")
     */
    private $sousCategories;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
    }



    public function getIdC(): ?int
    {
        return $this->idC;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }
    public function setNomC(?string $categorieNom): self
    {
        $this->nomC = $categorieNom;

        return $this;
    }

    public function setIdC(?int $id): self
    {
        $this->idC = $id;

        return $this;
    }

    public function getsousCategories()
    {
        return $this->sousCategories;
    }

    public function __toString()
    {
        return $this->getNomC() ;   }

    public function addSousCategory(Souscategorie $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->add($sousCategory);
            $sousCategory->setNomC($this);
        }

        return $this;
    }

    public function removeSousCategory(Souscategorie $sousCategory): self
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getNomC() === $this) {
                $sousCategory->setNomC(null);
            }
        }

        return $this;
    }
}
