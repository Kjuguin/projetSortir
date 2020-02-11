<?php

namespace App\Repository;

use App\Entity\Main;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Main|null find($id, $lockMode = null, $lockVersion = null)
 * @method Main|null findOneBy(array $criteria, array $orderBy = null)
 * @method Main[]    findAll()
 * @method Main[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Main::class);
    }

    // /**
    //  * @return Main[] Returns an array of Main objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Main
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
