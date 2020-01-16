<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
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
    public function index(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $basket = $session->get('panier', []);

        $basketData = [];
        
        foreach ($basket as $key => $qty) {
            $basketData[] = [
            'article' => $articleRepository->find($key),
            'quantity' => $qty
            ];
        }

        $total = 0;

        foreach ($basketData as $items) {
            $total += $items['article']->getPrixTtc() * $items['quantity'];
        }

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $basketData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/{id}", name="add")
     */
    public function add($id, SessionInterface $session)
    {
        $basket = $session->get('panier', []);

        if (!empty($basket[$id])) {
            $basket[$id]++;
        } else {
            $basket[$id] = 1;
        }
        
        $session->set('panier', $basket);

        $this->addFlash('success', 'Ajout au panier réussi');

        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, SessionInterface $session)
    {
        $basket = $session->get('panier', []);

        if (!empty($basket[$id])) {
            unset($basket[$id]);
        }

        $session->set('panier', $basket);

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute('panier_index');
    }
}
