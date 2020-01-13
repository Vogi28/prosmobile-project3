<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function homeSlider(PromoRepository $promoRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'promos' => $promoRepository->findAll(),
        ]);
    }
}
