<?php

namespace App\Repository;

use App\Entity\Thrift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Thrift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thrift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thrift[]    findAll()
 * @method Thrift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThriftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thrift::class);
    }

    /**
      * @return Thrift[] Returns an array of User objects
     */
    public function findAll() : array {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
      * @return Thrift Returns a object of thrift or null
     */
    public function findOneByID($value): ?Thrift
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Thrift[] Returns an array of Thrift objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Thrift
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
