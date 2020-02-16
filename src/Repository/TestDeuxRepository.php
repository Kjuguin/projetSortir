<?php

namespace App\Repository;

use App\Entity\TestDeux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TestDeux|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestDeux|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestDeux[]    findAll()
 * @method TestDeux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestDeuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestDeux::class);
    }

    // /**
    //  * @return TestDeux[] Returns an array of TestDeux objects
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
    public function findOneBySomeField($value): ?TestDeux
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
