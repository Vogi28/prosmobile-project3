<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\MarqueRepository;
use App\Repository\PromoRepository;
use App\Repository\ProRepository;
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
     * @Route("/telephones", name="phones", methods={"GET"})
     */
    public function phones(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '1']);
        $typeArt = $typeArtRepository->findOneBy(['id' => '1'])->getNom();
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
            'typeArt' => $typeArt,
        ]);
    }

    /**
     * @Route("/telephones/{slug<[a-zA-z]+>}", name="phones_by_brand")
     */
    public function phonesByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        ProRepository $proRepository,
        PromoRepository $promoRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('1', $marqueId);
        $typeArt = $typeArtRepository->findOneBy(['id' => '1'])->getNom();
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0] == "ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();

            return $this->render('sell_process/articleSelection.html.twig', [
                'articles' => $articles,
                'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
                'brand' => $slug,
                'typeArt' => $typeArt,
                'reduc' => $reduc,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articles,
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'typeArt' => $typeArt,
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/composants", name="components")
     */
    public function components(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $phones = $articleRepository->findBy(['typeArt' => '3']);
        $typeArt = $typeArtRepository->findOneBy(['id' => '3'])->getNom();
        return $this->render('sell_process/brandIndex.html.twig', [
            'phones' => $phones,
            'brands' => $marqueRepository->findAll(),
            'typeArt' => $typeArt,
        ]);
    }

    /**
     * @Route("/composants/{slug<[a-zA-z]+>}", name="components_by_brand")
     */
    public function componentsByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        ProRepository $proRepository,
        PromoRepository $promoRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('3', $marqueId);
        $typeArt = $typeArtRepository->findOneBy(['id' => '3'])->getNom();
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0] == "ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();

            return $this->render('sell_process/articleSelection.html.twig', [
                'articles' => $articles,
                'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
                'brand' => $slug,
                'typeArt' => $typeArt,
                'reduc' => $reduc,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articles,
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'typeArt' => $typeArt,
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/accessoires", name="accessories")
     */
    public function accessories(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $accessories = $articleRepository->findBy(['typeArt' => '2']);
        $typeArt = $typeArtRepository->findOneBy(['id' => '2'])->getNom();
        return $this->render('sell_process/brandIndex.html.twig', [
            'accessories' => $accessories,
            'brands' => $marqueRepository->findAll(),
            'typeArt' => $typeArt,
        ]);
    }

    /**
     * @Route("/accessoires/{slug<[a-zA-z]+>}", name="accessories_by_brand")
     */
    public function accessoriesByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        ProRepository $proRepository,
        PromoRepository $promoRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('2', $marqueId);
        $typeArt = $typeArtRepository->findOneBy(['id' => '2'])->getNom();
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0] == "ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();

            return $this->render('sell_process/articleSelection.html.twig', [
                'articles' => $articles,
                'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
                'brand' => $slug,
                'typeArt' => $typeArt,
                'reduc' => $reduc,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articles,
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'typeArt' => $typeArt,
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/reparations", name="repairs", methods={"GET"})
     */
    public function repairsIndex(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $repairs = $articleRepository->findBy(['typeArt' => '4']);
        $typeArt = $typeArtRepository->findOneBy(['id' => '4'])->getNom();
        return $this->render('sell_process/brandIndex.html.twig', [
            'repairs' => $repairs,
            'brands' => $marqueRepository->findAll(),
            'typeArt' => $typeArt,
        ]);
    }

    /**
     * @Route("/reparations/{slug<[a-zA-z]+>}", name="repairs_by_brand")
     */
    public function repairsByBrand(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        ProRepository $proRepository,
        PromoRepository $promoRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $marqueId = $marqueRepository->findOneBy(['nom' => $slug])->getId();
        $articles = $articleRepository->findByTypeArtBrand('4', $marqueId);
        $typeArt = $typeArtRepository->findOneBy(['id' => '4'])->getNom();
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0] == "ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();

            return $this->render('sell_process/articleSelection.html.twig', [
                'articles' => $articles,
                'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
                'brand' => $slug,
                'typeArt' => $typeArt,
                'reduc' => $reduc,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articles,
            'marque' => $marqueRepository->findOneby(['id' => $marqueId]),
            'brand' => $slug,
            'typeArt' => $typeArt,
            'promo' => $promo,
        ]);
    }
}
