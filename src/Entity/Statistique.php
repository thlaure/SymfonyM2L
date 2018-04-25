<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatistiqueRepository")
 */
class Statistique
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Atelier", inversedBy="statistiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atelier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Avis", inversedBy="statistiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $avis;

    public function getId()
    {
        return $this->id;
    }

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): self
    {
        $this->atelier = $atelier;

        return $this;
    }

    public function getAvis(): ?Avis
    {
        return $this->avis;
    }

    public function setAvis(?Avis $avis): self
    {
        $this->avis = $avis;

        return $this;
    }
}
