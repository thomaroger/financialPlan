<?php

namespace App\Repository;

use App\Entity\ForecastMoneyEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForecastMoneyEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForecastMoneyEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForecastMoneyEntry[]    findAll()
 * @method ForecastMoneyEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastMoneyEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForecastMoneyEntry::class);
    }

    // /**
    //  * @return ForecastMoneyEntry[] Returns an array of ForecastMoneyEntry objects
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
    public function findOneBySomeField($value): ?ForecastMoneyEntry
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
