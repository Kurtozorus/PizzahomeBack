<?php

namespace App\Repository;

use App\Entity\TakeAwayBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TakeAwayBooking>
 */
class TakeAwayBookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TakeAwayBooking::class);
    }

    public function findById(int $id): ?TakeAwayBooking
    {
        return $this->createQueryBuilder('tab')
            ->innerJoin('tab.user', 'u')
            ->innerJoin('tab.food', 'f')
            ->innerJoin('f.category', 'c')
            ->addSelect('tab', 'u', 'f', 'c')
            ->where('tab.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneorNullResult();
    }
    //    /**
    //     * @return TakeAwayBooking[] Returns an array of TakeAwayBooking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TakeAwayBooking
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
