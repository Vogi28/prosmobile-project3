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
     * @Route("/telephones/{slug<[a-zA-z]+>}", name="phones")
     */
    public function phonesIndex(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $marqueId = $marqueRepository->findOneByNom($slug)->getId();
        $phones = $articleRepository->findByTypeArtBrand('1', $marqueId);
        return $this->render('sell_process/brandIndex.html.twig', [
            'controller_name' => 'SellProcessController',
            'brands' => $marqueRepository->findAll(),
            'brand' => $slug,
            'phones' => $phones
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
