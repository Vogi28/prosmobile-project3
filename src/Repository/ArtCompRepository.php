<?php

namespace App\Repository;

use App\Entity\ArtComp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method ArtComp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtComp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtComp[]    findAll()
 * @method ArtComp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtCompRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtComp::class);
    }

    // /**
    //  * @return ArtComp[] Returns an array of ArtComp objects
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
    public function findOneBySomeField($value): ?ArtComp
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
