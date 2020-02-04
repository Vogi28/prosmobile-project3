<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function homeSlider(PromoRepository $promoRepository): Response
    {
        $today = date('Y-m-d');

        return $this->render('home/index.html.twig', [
            'promo' => $promoRepository->findOneByDate($today),
        ]);
    }
}
