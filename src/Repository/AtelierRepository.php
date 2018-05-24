<?php

namespace App\Repository;

use App\Entity\Atelier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe AtelierRepository.
 *
 * @method Atelier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atelier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atelier[]    findAll()
 * @method Atelier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class AtelierRepository extends ServiceEntityRepository
{
    /**
     * AtelierRepository constructor.
     *
     * @param RegistryInterface $registry Instance de la classe RegistryInterface.
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Atelier::class);
    }

    /**
     * Méthode d'exemple.
     *
     * @return Atelier[] Returns an array of Atelier objects
     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Atelier
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}