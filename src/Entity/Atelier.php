<?php

namespace App\Entity;

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
     * Accesseur du nombre de places maximum de l'atelier.
     * @return int|null
     */
    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    /**
     * Mutateur du nombre de places maximum de l'atelier.
     * @param int $nbPlacesMaxi
     * @return Atelier
     */
    public function setNbPlacesMaxi(int $nbPlacesMaxi): self
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }
}