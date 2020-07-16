<?php

namespace App\Repository;

use App\Entity\ForecastMoneyEntryInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForecastMoneyEntryInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForecastMoneyEntryInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForecastMoneyEntryInstance[]    findAll()
 * @method ForecastMoneyEntryInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastMoneyEntryInstanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForecastMoneyEntryInstance::class);
    }


    /**
      * @return ForecastMoneyEntryInstance[] Returns an array of User objects
     */
    public function findAll() : array {
        return $this->createQueryBuilder('fmei')
            ->getQuery()
            ->getResult();
    }
    

    /**
      * @return float[] Returns an array of User objects
     */
    public function findByMonthAndYear($month, $year) : array {
        return $this->createQueryBuilder('fmei')
            ->select("sum(fmei.price)")
            ->andWhere('fmei.month = :month')
            ->andWhere('fmei.year = :year')
            ->setParameter('month', $month)
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ForecastMoneyEntryInstance[] Returns an array of ForecastMoneyEntryInstance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForecastMoneyEntryInstance
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
