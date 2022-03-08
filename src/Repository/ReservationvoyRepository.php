<?php

namespace App\Repository;

use App\Entity\Reservationvoy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservationvoy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservationvoy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservationvoy[]    findAll()
 * @method Reservationvoy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationvoyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservationvoy::class);
    }

    // /**
    //  * @return Reservationvoy[] Returns an array of Reservationvoy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservationvoy
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
