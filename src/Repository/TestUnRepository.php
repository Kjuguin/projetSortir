<?php

namespace App\Repository;

use App\Entity\TestUn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TestUn|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestUn|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestUn[]    findAll()
 * @method TestUn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestUnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestUn::class);
    }

    public function afficher($param)
    {

        $sqb = $this->createQueryBuilder('s');

        //ajout param site
        if (!empty($param['site'])) {
            $sqb->where("s.noSite = :site");
            $sqb->setParameter("site", $param['site']);
        }

        //ajout param nom
        if (!empty($param['nom'])) {
            $sqb->andWhere("s.nom LIKE :nom");
            $sqb->setParameter("nom", '%' . $param['nom'] . '%');
        }

        $query = $sqb->getQuery();
        $result = $query->getResult();
        return $result;

    }

    // /**
    //  * @return TestUn[] Returns an array of TestUn objects
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
    public function findOneBySomeField($value): ?TestUn
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
