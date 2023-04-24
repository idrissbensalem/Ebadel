<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Souscategorie
 *
 * @ORM\Entity(repositoryClass="App\Repository\SousCategorieRepository")
 * @UniqueEntity(fields={"nom_s_c","nomC"},message="Le nom de la sous catégorie existe déja!")

 */
class Souscategorie
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     

     */
    private $id_s_c;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @ORM\Id
     * @Assert\NotBlank(message="le nom de la sous catégorie ne doit pas étre vide")
     */
    #[Assert\Length(
        min: 2,
        minMessage: 'le nom de la sous catégorie doit comporter au moins {{ limit }} caractères',
    )]
    private $nom_s_c;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
    * @ORM\JoinColumns({    
     *   @ORM\JoinColumn(name="nom_c", referencedColumnName="nom_c")
     * })
     */
    private $nomC;

       /**
     * @ORM\OneToMany(targetEntity="Marque", mappedBy="nomSC")
     */
    private $marques;

    public function __construct()
    {
        $this->marques = new ArrayCollection();
    }


    public function getIdSC(): ?int
    {
        return $this->id_s_c;
    }

    public function getNomSC(): ?string
    {
        return $this->nom_s_c;
    }

    public function getNomC(): ?Categorie
    {
        return $this->nomC;
    }

    public function setNomC(?Categorie $nomC): self
    {
        $this->nomC = $nomC;

        return $this;
    }
    public function setNomSC(?String $nom_s_c): self
    {
        $this->nom_s_c = $nom_s_c;

        return $this;
    }
    public function setIdSC(?int $id_s_c): self
    {
        $this->id_s_c = $id_s_c;

        return $this;
    }
    public function getMarques()
    {
        return $this->marques;
    }
    public function __toString()
    {
        return $this->getNomSC() ;   }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques->add($marque);
            $marque->setNomSC($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getNomSC() === $this) {
                $marque->setNomSC(null);
            }
        }

        return $this;
    }

}

