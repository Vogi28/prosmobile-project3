<?php

namespace App\Repository;

use App\Entity\Particulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Particulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Particulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Particulier[]    findAll()
 * @method Particulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticulierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Particulier::class);
    }

    // /**
    //  * @return Particulier[] Returns an array of Particulier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Particulier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByNomLike(string $string)
    {
        $articles = $this->createQueryBuilder('a')
            ->where('a.prenom LIKE :string')
            ->setParameter('string', '%'.$string.'%')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    
        $articles->setMaxResults(5);
            return $articles->getResult()
        ;
    }
}
