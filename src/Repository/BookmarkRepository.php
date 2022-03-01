<?php

namespace App\Repository;

use App\Entity\Bookmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }
    public function findByUser($user)
    {
        return $this->createQueryBuilder('b')
            ->join('b.Topicmark','s')
            ->addSelect('s')
            ->where('b.userBook=:user')
            ->setParameter('user',$user)
            ->select('t')->from('App:Topic','t')

            ->getQuery()->getResult();
    }
    public function findBook($user,$id)
    {
        return $this->createQueryBuilder('b')
            ->join('b.Topicmark','t')
            ->addSelect('b')
            ->Where('t.id=:id')
            ->setParameter('id',$id)
            ->andwhere('b.userBook=:user')
            ->setParameter('user',$user)

            /*->select('s')->from('App:Bookmark','s')*/
            ->getQuery()->getResult()
            ;
    }

    // /**
    //  * @return Bookmark[] Returns an array of Bookmark objects
    //  */
    /*

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bookmark
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
