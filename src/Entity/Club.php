<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Club.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ClubRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Club
{
    /**
     * ID du club.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom du club.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nomClub;

    /**
     * Accesseur de l'ID du club.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Accesseur du nom du club.
     *
     * @return null|string
     */
    public function getNomClub(): ?string
    {
        return $this->nomClub;
    }

    /**
     * Mutateur du nom du club.
     *
     * @param string $nomClub Nom du club à définir.
     *
     * @return Club
     */
    public function setNomClub(string $nomClub): self
    {
        $this->nomClub = $nomClub;

        return $this;
    }
}