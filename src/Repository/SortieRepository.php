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
        //ajout param site
        if (!empty($param['site'])) {
            $sqb->andWhere("s.noSite = :site");
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
            $sqb->andWhere("s.dateCloture >= :dateFin");
            $sqb->setParameter("dateFin", $param['dateFin']);
        }

        // ajout choix organisateur
        if (!empty($param['organisateur'])) {
            $sqb->andWhere("s.noOrganisateur = :organisateur");
            $sqb->setParameter("organisateur", $param['organisateur']);
        }

        // ajout choix inscrit
        if (!empty($param['inscrit'])) {
            $sqb->leftJoin("s.noInscriptions", 'i');
            $sqb->andWhere("i.noUser = :inscrit");
            $sqb->setParameter("inscrit", $param['inscrit']);
        }

        // ajout choix pas inscrit
        if (!empty($param['notInscrit'])) {

            $sqb2 = $this->createQueryBuilder('s2')
                ->select('s2.id')
                ->Join("s2.noInscriptions", 'i2')
                ->andWhere("i2.noUser = :notInscrit");

            $sqb->andWhere($sqb->expr()->notIn('s.id', $sqb2->getDQL()));

            $sqb->setParameter("notInscrit", $param['notInscrit']);
        }

        //ajout param raccourci date passée
        if (!empty($param['passee'])) {
            $sqb->andWhere("s.dateCloture < :passee");
            $sqb->setParameter("passee", $param['passee']);
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
