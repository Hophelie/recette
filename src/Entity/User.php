<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  @UniqueEntity(
     * fields={"email"}, 
     * message="Cet e-mail est déjà utilisé"
     * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="5",minMessage="Votre vot de passe doit faire 5 carractères minimum")
     */
    private $password;

    /** 
     * @assert\EqualTo(propertyPath="$password",message="Votre vot de passe doit être identique")
     */
    public $confirmMdp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setUsername(string $nom): self
    {
        $this->nom = $nom;

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
// Fonctions a ajouter pour que le  UserInterface fonctionne

    
    public function eraseCredentials(){}
    public function getSalt(){}
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

   
}
