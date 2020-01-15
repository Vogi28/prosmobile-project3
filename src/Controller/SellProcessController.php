<?php

namespace App\Controller;

use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_sell_")
 */
class SellProcessController extends AbstractController
{
    /**
     * @Route("/marque", name="brand")
     */
    public function brandsIndex(MarqueRepository $marqueRepository)
    {
        return $this->render('sell_process/brandIndex.html.twig', [
            'controller_name' => 'SellProcessController',
            'brands' => $marqueRepository->findAll()
        ]);
    }

    /**
     * @Route("/composants", name="component")
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
        return $this->render('sell_process/accesIndex.html.twig', [
            'controller_name' => 'SellProcessController',
        ]);
    }

    /**
     * @Route("/reparation", name="repair")
     */
    public function repairIndex()
    {
        return $this->render('sell_process/repairIndex.html.twig', [
            'controller_name' => 'SellProcessController',
        ]);
    }
}
