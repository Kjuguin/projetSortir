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
        $sqb->leftJoin("s.noInscriptions",'i');
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

        //ajout param date début
        if (!empty($param['dateDebut'])) {
            $sqb->andWhere("s.dateDebut >= :dateDebut");
            $sqb->setParameter("dateDebut", $param['dateDebut']);
        }

        //ajout param date fin
        if (!empty($param['dateFin'])) {
            $sqb->andWhere("s.dateCloture <= :dateFin");
            $date = DateTime::createFromFormat('Y-m-d', $param['dateFin']);
            $date->setTime(24, 00, 00);
            $date->format('Y-m-d H:i:s');
            $sqb->setParameter("dateFin", $date);
        }

        // ajout choix organisateur
        if (!empty($param['organisateur'])) {
            $sqb->andWhere("s.noOrganisateur = :organisateur");
            $sqb->setParameter("organisateur", $param['organisateur']);
        }

        // ajout choix inscrit
        if (!empty($param['inscrit'])) {
            $sqb->andWhere("i.noUser = :inscrit");
            $sqb->setParameter("inscrit", $param['inscrit']);
        }

        // ajout choix pas inscrit
        if (!empty($param['notInscrit'])) {
            $sqb->andWhere("i.noUser != :notInscrit OR i.noUser IS NULL");
            $sqb->setParameter("notInscrit", $param['notInscrit']);
        }

        //ajout param raccourci date passée
        if (!empty($param['passee'])) {
            $sqb->andWhere("s.dateCloture < :passee");
            $date = new DateTime();
            $date->setTime(00, 00, 00);
            $date->format('Y-m-d H:i:s');
            $sqb->setParameter("passee", $date);
        }

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
