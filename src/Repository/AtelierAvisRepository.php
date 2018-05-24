<?php

namespace App\Repository;

use App\Entity\AtelierAvis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe AtelierAvisRepository.
 *
 * @method AtelierAvis|null find($id, $lockMode = null, $lockVersion = null)
 * @method AtelierAvis|null findOneBy(array $criteria, array $orderBy = null)
 * @method AtelierAvis[]    findAll()
 * @method AtelierAvis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class AtelierAvisRepository extends ServiceEntityRepository
{
    /**
     * AtelierAvisRepository constructor.
     *
     * @param RegistryInterface $registry Instance de la classe RegistryInterface.
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AtelierAvis::class);
    }

    /**
     * Méthode d'exemple.
     *
     * @return AtelierAvis[] Returns an array of AtelierAvis objects
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
    public function findOneBySomeField($value): ?AtelierAvis
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