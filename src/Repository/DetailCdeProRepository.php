<?php

namespace App\Repository;

use App\Entity\DetailCdePro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DetailCdePro|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailCdePro|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailCdePro[]    findAll()
 * @method DetailCdePro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailCdeProRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailCdePro::class);
    }

    // /**
    //  * @return DetailCdePro[] Returns an array of DetailCdePro objects
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
    public function findOneBySomeField($value): ?DetailCdePro
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
