<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByTypeArtBrand($typeArtId, $marqueId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.typeArt = :typeArt')
            ->setParameter('typeArt', $typeArtId)
            ->andWhere('a.marque = :marque')
            ->setParameter('marque', $marqueId)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByTypeAndNom(int $typeArtId, array $array)
    {
        $count = count($array);
        for ($i=0; $i < $count; $i++) {
            $articles = $this->createQueryBuilder('a')
            ->andWhere('a.typeArt = :typeArt')
            ->setParameter('typeArt', $typeArtId)
            ->andWhere('a.nom LIKE :string')
            ->setParameter('string', $array[$i].'%')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
        }
        
            return $articles->getResult();
    }

    // public function findByNomLike(string $string)
    // {
    //     return $this->createQueryBuilder('a')
    //         ->where('a.nom LIKE :string')
    //         ->setParameter('string', '%'.$string.'%')
    //         ->orderBy('a.id', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    public function findByNomLike(string $string)
    {
        $articles = $this->createQueryBuilder('a')
            ->where('a.nom LIKE :string')
            ->setParameter('string', '%'.$string.'%')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    
        ;
            return $articles->setMaxResults(5)->getResult()
        ;
    }
    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
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
