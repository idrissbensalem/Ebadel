<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suggestion
 *
 * @ORM\Table(name="suggestion", indexes={@ORM\Index(name="id_client", columns={"id_client"})})

* @ORM\Entity(repositoryClass="App\Repository\SuggestionRepository")

 */
class Suggestion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_s", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idS;

    /**
     * @var string
     *
     * @ORM\Column(name="sugg_c", type="string", length=100, nullable=true)
     */
    private $suggC;

    /**
     * @var string
     *
     * @ORM\Column(name="sugg_s", type="string", length=100, nullable=true)
     */
    private $suggS;

    /**
     * @var string
     *
     * @ORM\Column(name="sugg_m", type="string", length=100, nullable=true)
     */
    private $suggM;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="Idu")
     * })
     */
    private $idClient;

/**
 * Get the value of idS
 */ 
public function getIdS()
{
    return $this->idS;
}

/**
 * Set the value of idS
 *
 * @return  self
 */ 
public function setIdS($idS)
{
    $this->idS = $idS;

    return $this;
}

/**
 * Get the value of suggC
 */ 
public function getSuggC()
{
    return $this->suggC;
}

/**
 * Set the value of suggC
 *
 * @return  self
 */ 
public function setSuggC($suggC)
{
    $this->suggC = $suggC;

    return $this;
}

/**
 * Get the value of suggS
 */ 
public function getSuggS()
{
    return $this->suggS;
}

/**
 * Set the value of suggS
 *
 * @return  self
 */ 
public function setSuggS($suggS)
{
    $this->suggS = $suggS;

    return $this;
}

/**
 * Get the value of suggM
 */ 
public function getSuggM()
{
    return $this->suggM;
}

/**
 * Set the value of suggM
 *
 * @return  self
 */ 
public function setSuggM($suggM)
{
    $this->suggM = $suggM;

    return $this;
}

/**
 * Get the value of idClient
 */ 
public function getIdClient()
{
    return $this->idClient;
}

/**
 * Set the value of idClient
 *
 * @return  self
 */ 
public function setIdClient($idClient)
{
    $this->idClient = $idClient;

    return $this;
}

}
