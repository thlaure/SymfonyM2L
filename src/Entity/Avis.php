<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Avis.
 *
 * @ORM\Entity(repositoryClass="App\Repository\AvisRepository")
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Avis
{
    /**
     * ID de l'avis.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Libellé de l'avis.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $libelleAvis;

    /**
     * Accesseur de l'ID de l'avis.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur du libellé de l'avis.
     *
     * @return null|string
     */
    public function getLibelleAvis(): ?string
    {
        return $this->libelleAvis;
    }

    /**
     * Mutateur du libellé de l'avis.
     *
     * @param string $libelleAvis Libellé à attribuer à l'avis.
     *
     * @return Avis
     */
    public function setLibelleAvis(string $libelleAvis): self
    {
        $this->libelleAvis = $libelleAvis;

        return $this;
    }
}