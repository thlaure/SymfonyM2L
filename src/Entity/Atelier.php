<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Atelier.
 *
 * @ORM\Entity(repositoryClass="App\Repository\AtelierRepository")
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Atelier
{
    /**
     * ID de l'atelier.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Libellé de l'atelier.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $libelleAtelier;

    /**
     * Nombre de places maximum de l'atelier.
     *
     * @ORM\Column(type="integer")
     */
    private $nbPlacesMaxi;

    /**
     * Accesseur de l'ID de l'atelier.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur du libellé de l'atelier.
     *
     * @return null|string
     */
    public function getLibelleAtelier(): ?string
    {
        return $this->libelleAtelier;
    }

    /**
     * Mutateur du libellé de l'atelier.
     *
     * @param string $libelleAtelier Libellé à attribuer à l'atelier.
     *
     * @return Atelier
     */
    public function setLibelleAtelier(string $libelleAtelier): self
    {
        $this->libelleAtelier = $libelleAtelier;

        return $this;
    }

    /**
     * Accesseur du nombre de places maximum de l'atelier.
     *
     * @return int|null
     */
    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    /**
     * Mutateur du nombre de places maximum de l'atelier.
     *
     * @param int $nbPlacesMaxi Nombre de places maximum à attribuer à l'atelier.
     *
     * @return Atelier
     */
    public function setNbPlacesMaxi(int $nbPlacesMaxi): self
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }
}