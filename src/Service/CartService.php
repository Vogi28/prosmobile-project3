<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;
    protected $articleRepository;

    public function __construct(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function index(): array
    {

        $basket = $this->session->get('panier', []);

        $basketData = [];

        foreach ($basket as $key => $qty) {
            $basketData[] = [
            'article' => $this->articleRepository->find($key),
            'quantity' => $qty
            ];
        }

        return $basketData;
    }

    public function ttlMath(array $basketData, int $promo, $user): int
    {

        $total = 0;
        if ($user !== null && $user->getRoles()[0] == 'ROLE_PRO') {
            foreach ($basketData as $items) {
                $total += $items['article']->getPrixHt() * $items['quantity'];
            }
        } else {
            foreach ($basketData as $items) {
                $total += $items['article']->getPrixTtc() * $items['quantity'];
            }
        }
        

        return $total * (1 - $promo / 100);
    }

    public function addItems($id, $promotion)
    {
        $basket = $this->session->get('panier', []);
        $promo = $this->session->get('promo', 0);

        $promo = $promotion;

        if (!empty($basket[$id])) {
            $basket[$id]++;
        } else {
            $basket[$id] = 1;
        }
        
        $this->session->set('panier', $basket);
        $this->session->set('promo', $promo);
    }

    public function delItems($id)
    {
        $basket = $this->session->get('panier', []);

        if (!empty($basket[$id])) {
            unset($basket[$id]);
        }
        
        $this->session->set('panier', $basket);
    }
}
