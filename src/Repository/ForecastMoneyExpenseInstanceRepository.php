<?php

namespace App\Repository;

use App\Entity\ForecastMoneyExpenseInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForecastMoneyEntryInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForecastMoneyEntryInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForecastMoneyEntryInstance[]    findAll()
 * @method ForecastMoneyEntryInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastMoneyExpenseInstanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForecastMoneyExpenseInstance::class);
    }


    /**
      * @return ForecastMoneyExpenseInstance[] Returns an array of User objects
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
}
