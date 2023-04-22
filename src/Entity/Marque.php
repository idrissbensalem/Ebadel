<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Marque
 *
 * @ORM\Table(name="marque", indexes={@ORM\Index(name="nom_m", columns={"nom_m"}), @ORM\Index(name="nom_c", columns={"nom_c"}), @ORM\Index(name="nom_s_c", columns={"nom_s_c"})})
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @UniqueEntity(fields={"nomM","nomSC","nomC"},message="Le nom de la marque existe déja!")
 */
class Marque
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_m", type="integer", nullable=false)
* @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idM;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_m", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank(message="le nom de la marque ne doit pas étre vide")
     */
    #[Assert\Length(
        min: 2,
        minMessage: 'le nom de la sous catégorie doit comporter au moins {{ limit }} caractères',
    )]
    private $nomM;

    /**
     * @var \Souscategorie
     *
     * @ORM\ManyToOne(targetEntity="Souscategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_s_c", referencedColumnName="nom_s_c")
     * })
     */
    private $nomSC;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_c", referencedColumnName="nom_c")
     * })
     */
    private $nomC;

    public function getIdM(): ?int
    {
        return $this->idM;
    }

    public function getNomM(): ?string
    {
        return $this->nomM;
    }

    public function getNomSC(): ?Souscategorie
    {
        return $this->nomSC;
    }

    public function setNomSC(?Souscategorie $nomSC): self
    {
        $this->nomSC = $nomSC;

        return $this;
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
    public function setIdM(?int $idM): self
    {
        $this->idM = $idM;

        return $this;
    }
    public function setNomM(?String $nomM): self
    {
        $this->nomM = $nomM;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomM() ;   }


}
