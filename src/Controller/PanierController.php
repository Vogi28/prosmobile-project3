<?php

namespace App\Controller;

use DateTime;
use App\Entity\CommandePar;
use App\Entity\CommandePro;
use App\Entity\DetailCdePro;
use App\Service\CartService;
use App\Entity\DetailCdePart;
use App\Service\MailerService;
use App\Repository\PromoRepository;
use App\Repository\ArticleRepository;
use App\Service\ManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function validaton(SessionInterface $session, CartService $cartService)
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
     * @Route("/reservation", name="reservation")CartService $cartService
     */
    public function reza(
        SessionInterface $session,
        ArticleRepository $articleRepository,
        PromoRepository $promoRepository,
        EntityManagerInterface $emi,
        MailerService $mailer,
        ManagerService $managerService
    ) {
        $panier = $session->get('panier', []);
        
        $date = new DateTime('now');
        if ($this->getUser()->getRoles()[0] == 'ROLE_PARTICULIER') {
            $cdePar = new CommandePar();
            
            $cdePar->setParticulier($this->getUser()->getParticulier());
            $cdePar->addPromo($promoRepository->findOneByDate($date));
            $emi->persist($cdePar);
        
            $articles = [];
            foreach ($panier as $id => $qty) {
                $articles [] = $articleRepository->findOneById($id);
                foreach ($articles as $article) {
                    $dtlCdePar = new DetailCdePart();
                    $dtlCdePar->setNomArt($article->getNom());
                    $dtlCdePar->setQuantite($qty);
                    $dtlCdePar->setPrixHt($article->getPrixHt());
                    $dtlCdePar->setPrixTtc($article->getPrixTtc());
                    $dtlCdePar->setPromo($cdePar->getPromo()[0]->getPourcentage());
                    $dtlCdePar->setTotal($qty * ($article->getPrixTtc() * (
                        1 - (($cdePar->getPromo()[0]->getPourcentage()) / 100))));
                    // $dtlCdePar->addArticle($article);
                    $dtlCdePar->setCommandePar($cdePar);
    
                    $cdePar->addDetailCdePart($dtlCdePar);
                    $managerService->persFLush($dtlCdePar);
                }
            }
        } elseif ($this->getUser()->getRoles()[0] == 'ROLE_PRO') {
            $cdePro = new CommandePro();
            
            $cdePro->setPro($this->getUser()->getPro());
            $emi->persist($cdePro);
            
            $articles = [];
            foreach ($panier as $id => $qty) {
                $articles [] = $articleRepository->findOneById($id);
                foreach ($articles as $article) {
                    $dtlCdePro = new DetailCdePro();
                    $dtlCdePro->setNomArt($article->getNom());
                    $dtlCdePro->setQuantite($qty);
                    $dtlCdePro->setPrixHt($article->getPrixHt());
                    $dtlCdePro->setRemise($cdePro->getPro()->getPourcentRemise());
                    $dtlCdePro->setTotal($qty * ($article->getPrixHt() * (
                        1 - (($cdePro->getPro()->getPourcentRemise()) / 100))));
                    $dtlCdePro->addArticle($article);
                    $dtlCdePro->setCommandePro($cdePro);

                    $cdePro->addDetailCdePro($dtlCdePro);
                    $managerService->persFLush($dtlCdePro);
                }
            }
        }

        $session->remove('panier');
        $session->remove('promo');
        
        $this->addFlash('success', 'Réservation envoyée');

        $mailer->sendReza($this->getUser()->getEmail(), $articles);

        return $this->redirectToRoute('home');
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
