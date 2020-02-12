<?php

namespace App\Repository;

use App\Entity\Sortie;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
//use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function afficher($param)
    {

        $sqb = $this->createQueryBuilder('s');

        if (!empty($param['site'])){
            $sqb->where("s.noSite = :site");
            $sqb->setParameter("site", $param['site']);
        }

        $sqb->andWhere("s.nom LIKE :nom");
        $sqb->setParameter("nom", '%' . $param['nom'] . '%');
        $sqb->andWhere("s.dateDebut >= :dateDebut");
        $sqb->setParameter("dateDebut", $param['dateDebut']);

        if (!empty($param['dateFin'])){
            $sqb->andWhere("s.dateCloture <= :dateFin");
            $date = DateTime::createFromFormat('Y-m-d', $param['dateFin']);
            $date->setTime(24, 00, 00);
            $date->format('Y-m-d H:i:s');
            $sqb->setParameter("dateFin", $date);
        }

        if (!empty($param['organisateur'])){
            $sqb->andWhere("s.noOrganisateur = :organisateur");
            $sqb->setParameter("organisateur", $param['organisateur']);
        }

        dump($param['organisateur']);


        $query = $sqb->getQuery();
        $result = $query->getResult();
        return $result;

    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
