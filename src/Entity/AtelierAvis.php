<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AtelierAvisRepository")
 */
class AtelierAvis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Atelier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atelier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $avis;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * Accesseur de l'ID de la classe intermédiaire.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur de l'atelier de l'objet courant de la classe intermédiaire.
     * @return Atelier|null
     */
    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    /**
     * Mutateur de l'atelier de l'objet courant de la classe intermédiaire.
     * @param Atelier|null $atelier
     * @return AtelierAvis
     */
    public function setAtelier(?Atelier $atelier): self
    {
        $this->atelier = $atelier;

        return $this;
    }

    /**
     * Accesseur de l'avis de l'objet courant de la classe intermédiaire.
     * @return Avis|null
     */
    public function getAvis(): ?Avis
    {
        return $this->avis;
    }

    /**
     * Mutateur de l'avis de l'objet courant de la classe intermédiaire.
     * @param Avis|null $avis
     * @return AtelierAvis
     */
    public function setAvis(?Avis $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Accesseur de la quantité de couples Atelier/Avis.
     * @return int|null
     */
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    /**
     * Mutateur de la quantité de couples Atelier/Avis.
     * @param int $quantite
     * @return AtelierAvis
     */
    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}