<?php

namespace App\Entity;

use App\Repository\AlimentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlimentRepository::class)
 */
class Aliment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $calories;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $proteines;

    /**
     * @ORM\Column(type="integer")
     */
    private $glucides;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lipides;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
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

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(?int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getProteines(): ?int
    {
        return $this->proteines;
    }

    public function setProteines(?int $proteines): self
    {
        $this->proteines = $proteines;

        return $this;
    }

    public function getGlucides(): ?int
    {
        return $this->glucides;
    }

    public function setGlucides(int $glucides): self
    {
        $this->glucides = $glucides;

        return $this;
    }

    public function getLipides(): ?int
    {
        return $this->lipides;
    }

    public function setLipides(?int $lipides): self
    {
        $this->lipides = $lipides;

        return $this;
    }
}
