<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvisRepository")
 */
class Avis
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
    private $libelleAvis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistique", mappedBy="avis")
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

    public function getLibelleAvis(): ?string
    {
        return $this->libelleAvis;
    }

    public function setLibelleAvis(string $libelleAvis): self
    {
        $this->libelleAvis = $libelleAvis;

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
            $statistique->setAvis($this);
        }

        return $this;
    }

    public function removeStatistique(Statistique $statistique): self
    {
        if ($this->statistiques->contains($statistique)) {
            $this->statistiques->removeElement($statistique);
            // set the owning side to null (unless already changed)
            if ($statistique->getAvis() === $this) {
                $statistique->setAvis(null);
            }
        }

        return $this;
    }
}
