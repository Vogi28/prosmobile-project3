<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier", name="panier_")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, CartService $cartService)
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $cartService->index(),
            'total' => $cartService->ttlMath(
                $cartService->index(),
                $session->get('promo', 0),
                $this->getUser()
            ),
            'promo' => $session->get('promo', 0)

        ]);
    }
    /**
     * @Route("/validation", name="validation")
     */
    public function reservation(SessionInterface $session, CartService $cartService)
    {
        return $this->render('panier/validation.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $cartService->index(),
            'total' => $cartService->ttlMath(
                $cartService->index(),
                $session->get('promo', 0),
                $this->getUser()
            ),
            'promo' => $session->get('promo', 0)

        ]);
    }

    /**
     * @Route("/add/{id}/{promo}", name="add")
     */
    public function add($id, $promo, CartService $cartService)
    {
           
        $cartService->addItems($id, $promo);
        
        $this->addFlash('success', 'Ajout au panier réussi');

        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, CartService $cartService)
    {
        $cartService->delItems($id);

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute('panier_index');
    }
}
