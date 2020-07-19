<?php

namespace App\Repository;

use App\Entity\ForecastMoneyExpense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForecastMoneyEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForecastMoneyEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForecastMoneyEntry[]    findAll()
 * @method ForecastMoneyEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastMoneyExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForecastMoneyExpense::class);
    }

    /**
      * @return ForecastMoneyEnxpense Returns a object of ForecastMoneyEnxpense or null
     */
    public function findOneByID($value): ?ForecastMoneyExpense
    {
        return $this->createQueryBuilder('fme')
            ->andWhere('fme.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
