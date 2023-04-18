<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="marque", indexes={@ORM\Index(name="nom_c", columns={"nom_c"}), @ORM\Index(name="nom_s_c", columns={"nom_s_c"}), @ORM\Index(name="nom_m", columns={"nom_m"})})
 * @ORM\Entity
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
     */
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


}
