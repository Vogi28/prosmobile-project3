<?php

namespace App\Repository;

use App\Entity\CommandePar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandePar|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePar|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePar[]    findAll()
 * @method CommandePar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeParRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandePar::class);
    }

    // /**
    //  * @return CommandePar[] Returns an array of CommandePar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandePar
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
