<?php

namespace App\Entity;

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
     * Accesseur de l'ID de l'avis.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur du libellé de l'avis.
     * @return null|string
     */
    public function getLibelleAvis(): ?string
    {
        return $this->libelleAvis;
    }

    /**
     * Mutateur du libellé de l'avis.
     * @param string $libelleAvis
     * @return Avis
     */
    public function setLibelleAvis(string $libelleAvis): self
    {
        $this->libelleAvis = $libelleAvis;

        return $this;
    }
}