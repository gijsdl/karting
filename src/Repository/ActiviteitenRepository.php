<?php

namespace App\Repository;

use App\Entity\Activiteiten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activiteiten|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activiteiten|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activiteiten[]    findAll()
 * @method Activiteiten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteitenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activiteiten::class);
    }

    public function getBeschikbareActiviteiten($userid)
    {
        date_default_timezone_set("Europe/Amsterdam");
        $dateNow = date('Y-m-d');
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->where(':userid NOT MEMBER OF a.users')
            ->andWhere('a.datum > :date')
            ->orderBy('a.datum')
            ->setParameter('userid', $userid)
            ->setParameter('date', $dateNow);

        return $qb->getQuery()->getResult();
    }

    public function getIngeschrevenActiviteiten($userid)
    {
        date_default_timezone_set("Europe/Amsterdam");
        $dateNow = date('Y-m-d');
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->where(':userid MEMBER OF a.users')
            ->andWhere('a.datum > :date')
            ->orderBy('a.datum')
            ->setParameter('userid', $userid)
            ->setParameter('date', $dateNow);

        return $qb->getQuery()->getResult();
    }

    public function getTotaal($activiteiten)
    {

        $totaal = 0;
        foreach ($activiteiten as $a) {
            $totaal += $a->getSoort()->getPrijs();
        }
        return $totaal;

    }

    // /**
    //  * @return Activiteiten[] Returns an array of Activiteiten objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Activiteiten
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
