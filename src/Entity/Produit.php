<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="nom_s_c", columns={"nom_s_c"}), @ORM\Index(name="nom_c", columns={"nom_c", "nom_s_c", "nom_m"}), @ORM\Index(name="nom_m", columns={"nom_m"}), @ORM\Index(name="IDX_29A5EC272AF2F06E", columns={"nom_c"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")

 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idP;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

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
     * @var \Souscategorie
     *
     * @ORM\ManyToOne(targetEntity="Souscategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_s_c", referencedColumnName="nom_s_c")
     * })
     */
    private $nomSC;

    /**
     * @var \Marque
     *
     * @ORM\ManyToOne(targetEntity="Marque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nomM", referencedColumnName="id_m"),
     *   @ORM\JoinColumn(name="nomM", referencedColumnName="nom_m")
     * })
     */
    private $nomM;

    public function getIdP(): ?int
    {
        return $this->idP;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getNomSC(): ?Souscategorie
    {
        return $this->nomSC;
    }

    public function setNomSC(?Souscategorie $nomSC): self
    {
        $this->nomSC = $nomSC;

        return $this;
    }

    public function getNomM(): ?Marque
    {
        return $this->nomM;
    }

    public function setNomM(?Marque $nomM): self
    {
        $this->nomM = $nomM;

        return $this;
    }


}
