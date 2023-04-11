<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @Vich\Uploadable
  *@UniqueEntity("cin",message="cin est deja exist") 
    *@UniqueEntity("tel",message="cin est deja exist") 
 */
class User implements UserInterface , \Serializable

{

    /**
     * @var int
     *
     * @ORM\Column(name="Idu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="Cin", type="string", length=20, nullable=false)
     *   @Assert\Positive 
     *  @Assert\Length(min="8", minMessage="Votre cin doit faire minimum 8 caractères")
     */
    private $cin;

    /**
     * @var string
     * @ORM\Column(name="Nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="Prenom", type="string", length=20, nullable=false)
     */
    private $prenom;

    
    
    /**
     * @var string
     * @ORM\Column(name="Tel", type="string", length=20, nullable=false)
     * @Assert\Length(min="8", minMessage="Votre tel doit faire minimum 8 caractères")
     * @Assert\Positive  
     */
    private $tel;

    /**
     * @var string
     * @ORM\Column(name="Email", type="string", length=38, nullable=false)
        * @Assert\NotBlank
     */
    private $email;

    /**
     * 
     * @var string
     * @ORM\Column(name="Password", type="string", length=50, nullable=false)
       *      @Assert\Length(min="4", minMessage="Votre password doit faire minimum 4 caractères")
          * @Assert\NotBlank
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=40, nullable=false)
   
     */
    private $image;

      /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="Image")
     * @var File
     */
    private $imageFile;
    /**
     * @var int|null
     *
     * @ORM\Column(name="Role", type="integer", nullable=true)
     */
    private $role = '0';

    /**
     * @var \DateTime|null
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $datenaissance;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
  
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImageFile( $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(?int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }
        /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function getRoles(){}


  

    public function getSalt(){}
    public function eraseCredentials(){}
    public function getUsername(){}

    public function serialize(){
    return serialize([
        $this->id,
        $this->prenom,
        $this->tel,
        $this->dateNaissance,
        $this->Nom,
        $this->email,
        $this->password
     ] );
    }
 public function unserialize ($string){
    list (
        $this->id,
        $this->prenom,
        $this->tel,
        $this->dateNaissance,
        $this->Nom,
        $this->email,
        $this->password
    ) = unserialize($string, ['allowed classes' => false]);
}

}