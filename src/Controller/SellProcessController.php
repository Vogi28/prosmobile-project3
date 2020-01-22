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
    public function componentsIndex(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '3']);
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
        ]);
    }

    // TODO - TERMINER tri par cat composant, puis par marque de téléphone, puis par modèle de téléphone compatible :

    /**
     * @Route("/composants/{slug<[a-zA-z]+>}", name="components_by_brand")
     */
    public function componentsByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('3', $marqueId);
        return $this->render('sell_process/articleSelection.html.twig', [
            'controller_name' => 'SellProcessController',
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/accessoires", name="accessories")
     */
    public function accessoriesIndex(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '2']);
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
        ]);
    }

    // TODO - TERMINER tri par cat accessoire, puis par marque de téléphone, puis par modèle de téléphone compatible :

    /**
     * @Route("/accessoires/{slug<[a-zA-z]+>}", name="accessories_by_brand")
     */
    public function accessoriesByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('2', $marqueId);
        return $this->render('sell_process/articleSelection.html.twig', [
            'controller_name' => 'SellProcessController',
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/reparations", name="repairs")
     */
    public function repairsIndex(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '4']);
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
        ]);
    }

    // TODO - TERMINER tri par cat reparation, puis par marque de téléphone, puis par modèle de téléphone compatible

    /**
     * @Route("/reparations/{slug<[a-zA-z]+>}", name="repairs_by_brand")
     */
    public function repairsByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('4', $marqueId);
        return $this->render('sell_process/articleSelection.html.twig', [
            'controller_name' => 'SellProcessController',
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'articles' => $articles
        ]);
    }
}
