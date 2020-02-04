<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\TypeArt;
use App\Form\TypeArtType;
use App\Repository\ArticleRepository;
use App\Repository\PromoRepository;
use App\Repository\ProRepository;
use App\Repository\TypeArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/art")
 */
class TypeArtController extends AbstractController
{
    /**
     * @Route("/", name="type_art_index", methods={"GET"})
     */
    public function index(TypeArtRepository $typeArtRepository): Response
    {
        return $this->render('type_art/index.html.twig', [
            'type_arts' => $typeArtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_art_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeArt = new TypeArt();
        $form = $this->createForm(TypeArtType::class, $typeArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeArt);
            $entityManager->flush();

            return $this->redirectToRoute('type_art_index');
        }

        return $this->render('type_art/new.html.twig', [
            'type_art' => $typeArt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_art_show", methods={"GET"})
     */
    public function show(
        Article $article,
        TypeArt $typeArt,
        PromoRepository $promoRepository,
        ProRepository $proRepository,
        ArticleRepository $articleRepository
    ): Response {
        $today = date('Y-m-d');
        $articles = $typeArt->getArticles();
        if ($this->getUser() !== null && $this->getUser()->getRoles()[0] == "ROLE_PRO") {
            $reduc = $proRepository->findOneById($this->getUser()->getPro())->getPourcentRemise();
            $prixHt = $articleRepository->findOneById(['id' => $article->getId()])->getPrixHt();
            $prixHtReduit = (round(($prixHt * (1 - $reduc / 100)), 2)); // arrondit 2 chiffres après la virgule

            return $this->render('type_art/show.html.twig', [
                'type_art' => $typeArt,
                'articles' => $articles,
                'reduc' => $reduc,
                'prix_ht_reduit' => $prixHtReduit,
            ]);
        }
        $promo = $promoRepository->findOneByDate($today)->getPourcentage();
        $prixTtc = $articleRepository->findOneById(['id' => $article->getId()])->getPrixTtc();
        $prixTtcReduit = (round(($prixTtc * (1 - $promo / 100)), 2)); // arrondit 2 chiffres après la virgule

        return $this->render('type_art/show.html.twig', [
            'type_art' => $typeArt,
            'articles' => $articles,
            'promo' => $promo,
            'prix_ttc_reduit' => $prixTtcReduit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_art_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeArt $typeArt): Response
    {
        $form = $this->createForm(TypeArtType::class, $typeArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_art_index');
        }

        return $this->render('type_art/edit.html.twig', [
            'type_art' => $typeArt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_art_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeArt $typeArt, EntityManagerInterface $emi): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeArt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeArt);
            $entityManager->flush();

            $emi->getConnection()->exec('ALTER TABLE type_art AUTO_INCREMENT = 1');
        }

        return $this->redirectToRoute('type_art_index');
    }
}
