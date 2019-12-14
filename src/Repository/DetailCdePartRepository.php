<?php

namespace App\Repository;

use App\Entity\DetailCdePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DetailCdePart|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailCdePart|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailCdePart[]    findAll()
 * @method DetailCdePart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailCdePartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailCdePart::class);
    }

    // /**
    //  * @return DetailCdePart[] Returns an array of DetailCdePart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailCdePart
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
