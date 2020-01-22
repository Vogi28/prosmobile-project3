<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\TypeArt;
use App\Repository\ArticleRepository;
use App\Repository\MarqueRepository;
use App\Repository\TypeArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_sell_")
 */
class SellProcessController extends AbstractController
{
    /**
     * @Route("/telephones", name="phone_brands", methods={"GET"})
     */
    public function phones(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '1']);
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/telephones/{slug<[a-zA-z]+>}", name="phones_by_brand")
     */
    public function phonesByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('1', $marqueId);
        return $this->render('sell_process/articleSelection.html.twig', [
            'controller_name' => 'SellProcessController',
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/composants", name="components")
     */
    public function componentsIndex()
    {
        return $this->render('sell_process/compIndex.html.twig', [
            'controller_name' => 'SellProcessController',
        ]);
    }

    /**
     * @Route("/accessoires", name="accessories")
     */
    public function accessoriesIndex()
    {
        return $this->render('sell_process/accessIndex.html.twig', [
            'controller_name' => 'SellProcessController',
        ]);
    }

    /**
     * @Route("/reparation", name="repairs")
     */
    public function repairsIndex()
    {
        return $this->render('sell_process/repairIndex.html.twig', [
            'controller_name' => 'SellProcessController',
        ]);
    }
}
