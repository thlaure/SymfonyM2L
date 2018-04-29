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
     * @ORM\ManyToMany(targetEntity="App\Entity\Avis")
     */
    private $avis;

    /**
     * Atelier constructor.
     */
    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    /**
     * Accesseur de l'ID de l'atelier.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur du libellé de l'atelier.
     * @return null|string
     */
    public function getLibelleAtelier(): ?string
    {
        return $this->libelleAtelier;
    }

    /**
     * Mutateur du libellé de l'atelier.
     * @param string $libelleAtelier
     * @return Atelier
     */
    public function setLibelleAtelier(string $libelleAtelier): self
    {
        $this->libelleAtelier = $libelleAtelier;

        return $this;
    }

    /**
     * Accesseur du nombre de places maximum dans l'atelier.
     * @return int|null
     */
    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    /**
     * Mutateur du nombre de places maximum dans l'atelier.
     * @param int $nbPlacesMaxi
     * @return Atelier
     */
    public function setNbPlacesMaxi(int $nbPlacesMaxi): self
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * Accesseur des avis laissés sur l'atelier.
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    /**
     * Ajout d'un avis sur l'atelier.
     * @param Avis $avis
     * @return Atelier
     */
    public function addAvi(Avis $avis): self
    {
        if (!$this->avis->contains($avis)) {
            $this->avis[] = $avis;
        }

        return $this;
    }

    /**
     * Suppression d'un avis sur l'atelier.
     * @param Avis $avis
     * @return Atelier
     */
    public function removeAvi(Avis $avis): self
    {
        if ($this->avis->contains($avis)) {
            $this->avis->removeElement($avis);
        }

        return $this;
    }
}
