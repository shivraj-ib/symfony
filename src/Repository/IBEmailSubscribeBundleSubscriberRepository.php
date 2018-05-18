<?php

namespace App\Repository;

use App\Entity\IBEmailSubscribeBundleSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IBEmailSubscribeBundleSubscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method IBEmailSubscribeBundleSubscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method IBEmailSubscribeBundleSubscriber[]    findAll()
 * @method IBEmailSubscribeBundleSubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IBEmailSubscribeBundleSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IBEmailSubscribeBundleSubscriber::class);
    }

//    /**
//     * @return IBEmailSubscribeBundleSubscriber[] Returns an array of IBEmailSubscribeBundleSubscriber objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IBEmailSubscribeBundleSubscriber
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
