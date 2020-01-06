<?php

namespace App\Repository;

use App\Entity\TypeArt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeArt|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeArt|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeArt[]    findAll()
 * @method TypeArt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeArtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeArt::class);
    }

    // /**
    //  * @return TypeArt[] Returns an array of TypeArt objects
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
    public function findOneBySomeField($value): ?TypeArt
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
