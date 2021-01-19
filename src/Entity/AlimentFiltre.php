<?php

namespace App\Entity;

use App\Repository\AlimentFiltreRepository;


class AlimentFiltre
{
    

   
    private $prixMax;

  
    private $glucidesMax;


    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    public function setPrixMax(?int $prixMax): self
    {
        $this->prixMax = $prixMax;

        return $this;
    }

    public function getGlucidesMax(): ?int
    {
        return $this->glucidesMax;
    }

    public function setGlucidesMax(?int $glucidesMax): self
    {
        $this->glucidesMax = $glucidesMax;

        return $this;
    }
}
