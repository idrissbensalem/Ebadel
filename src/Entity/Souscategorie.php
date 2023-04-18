<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Souscategorie
 *
 * @ORM\Table(name="souscategorie", indexes={@ORM\Index(name="nom_c", columns={"nom_c"}), @ORM\Index(name="nom_s_c", columns={"nom_s_c"})})
 * @ORM\Entity
 */
class Souscategorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_s_c", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idSC;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_s_c", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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

    public function getIdSC(): ?int
    {
        return $this->idSC;
    }

    public function getNomSC(): ?string
    {
        return $this->nomSC;
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


}
