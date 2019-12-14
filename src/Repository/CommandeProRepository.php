<?php

namespace App\Repository;

use App\Entity\CommandePro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandePro|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePro|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePro[]    findAll()
 * @method CommandePro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeProRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandePro::class);
    }

    // /**
    //  * @return CommandePro[] Returns an array of CommandePro objects
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
    public function findOneBySomeField($value): ?CommandePro
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
