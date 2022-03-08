<?php

namespace App\Repository;

use App\Entity\CarteFidelite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarteFidelite|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarteFidelite|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarteFidelite[]    findAll()
 * @method CarteFidelite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteFideliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteFidelite::class);
    }

    // /**
    //  * @return CarteFidelite[] Returns an array of CarteFidelite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarteFidelite
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
