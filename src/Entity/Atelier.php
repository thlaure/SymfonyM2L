<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AtelierRepository")
 */
class Atelier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleAtelier;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlacesMaxi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistique", mappedBy="atelier")
     */
    private $statistiques;

    public function __construct()
    {
        $this->statistiques = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLibelleAtelier(): ?string
    {
        return $this->libelleAtelier;
    }

    public function setLibelleAtelier(string $libelleAtelier): self
    {
        $this->libelleAtelier = $libelleAtelier;

        return $this;
    }

    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    public function setNbPlacesMaxi(int $nbPlacesMaxi): self
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * @return Collection|Statistique[]
     */
    public function getStatistiques(): Collection
    {
        return $this->statistiques;
    }

    public function addStatistique(Statistique $statistique): self
    {
        if (!$this->statistiques->contains($statistique)) {
            $this->statistiques[] = $statistique;
            $statistique->setAtelier($this);
        }

        return $this;
    }

    public function removeStatistique(Statistique $statistique): self
    {
        if ($this->statistiques->contains($statistique)) {
            $this->statistiques->removeElement($statistique);
            // set the owning side to null (unless already changed)
            if ($statistique->getAtelier() === $this) {
                $statistique->setAtelier(null);
            }
        }

        return $this;
    }
}
