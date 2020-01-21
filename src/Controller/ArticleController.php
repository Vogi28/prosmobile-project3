<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArtCompRepository;
use App\Repository\ArticleRepository;
use App\Repository\MarqueRepository;
use App\Repository\PromoRepository;
use App\Repository\ProRepository;
use App\Repository\TypeArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(
        Article $article,
        ArticleRepository $articleRepository,
        PromoRepository $promoRepository,
        ProRepository $proRepository
    ): Response {
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0]=="ROLE_PRO") {
            $reduc = $proRepository->findOneById($this->getUser()->getPro())->getPourcentRemise();
            $prixHt = $articleRepository->findOneById(['id' => $article->getId()])->getPrixHt();
            $prixHtReduit = (round(($prixHt*(1-$reduc/100)), 2)); // arrondit 2 chiffres après la virgule

            return $this->render('article/index.html.twig', [
                'articles' => $articleRepository->findAll(),
                'marque' => $articleRepository->findOneById(['id' => $article->getId()])->getMarque(),
                'reduc' => $reduc,
                'prix_ht_reduit' => $prixHtReduit,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();
        $prixTtc = $articleRepository->findOneById(['id' => $article->getId()])->getPrixTtc();
        $prixTtcReduit = (round(($prixTtc*(1-$promo/100)), 2)); // arrondit 2 chiffres après la virgule

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'marque' => $articleRepository->findOneById(['id' => $article->getId()])->getMarque(),
            'promo' => $promo,
            'prix_ttc_reduit' => $prixTtcReduit,
        ]);
    }

    /**
     * @Route("/marque/{slug<[a-zA-z]+>}", name="article_marque", methods={"GET"})
     */
    public function oneBrandindex(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {
        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articleRepository->findBy(['marque' => $marqueRepository->findOneByNom($slug)]),
            'marque' => $marqueRepository->findOneByNom($slug)
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug1<[a-zA-z]+>}/{slug2<[a-zA-z]+>}/{id}", name="article_show", methods={"GET"})
     */
    public function show(
        string $slug2,
        string $slug1,
        int $id,
        ArticleRepository $articleRepository,
        ArtCompRepository $artCompRepository,
        MarqueRepository $marqueRepository,
        PromoRepository $promoRepository,
        ProRepository $proRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0]=="ROLE_PRO") {
            $reduc = $proRepository->findOneById($this->getUser()->getPro())->getPourcentRemise();
            $prixHt = $articleRepository->findOneById(['id' => $id])->getPrixHt();
            $prixHtReduit = (round(($prixHt*(1-$reduc/100)), 2)); // arrondit 2 chiffres après la virgule

            $artComps = $artCompRepository->findByArtId(['artId' => $articleRepository->findOneBy(['id' => $id])]);
            $artCompId = [];
            foreach ($artComps as $artcomp) {
                $artCompId[] = $articleRepository->findOneBy(['typeArt' => $artcomp->getArtCompId()]);
            }
            $artCompPrixHT = $articleRepository
                ->findOneBy(['id' => $artCompRepository->findOneBy(['artId' => $artcomp->getArtId()])])->getPrixHt();
            $artCompHTreduit = (round(($artCompPrixHT*(1-$reduc/100)), 2));

            return $this->render('article/show.html.twig', [
                'article' => $articleRepository->findOneBy(['id' => $id]),
                'type_art' => $typeArtRepository->findOneByNom($slug1),
                'art_comps' => $artCompId,
                'marque' => $marqueRepository->findOneByNom($slug2),
                'reduc' => $reduc,
                'prix_ht_reduit' => $prixHtReduit,
                'art_comp_HT_reduit' => $artCompHTreduit
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();
        $prixTtc = $articleRepository->findOneById(['id' => $id])->getPrixTtc();
        $prixTtcReduit = (round(($prixTtc*(1-$promo/100)), 2)); // arrondit 2 chiffres après la virgule

        $artComps = $artCompRepository->findByArtId(['artId' => $articleRepository->findOneBy(['id' => $id])]);
        $artCompId = [];
        foreach ($artComps as $artcomp) {
            $artCompId[] = $articleRepository->findOneBy(['typeArt' => $artcomp->getArtCompId()]);
        }
        $artCompPrixTTC = $articleRepository
            ->findOneBy(['id' => $artCompRepository->findOneBy(['artId' => $artcomp->getArtId()])])->getPrixTtc();
        $artCompTTCreduit = (round(($artCompPrixTTC*(1-$promo/100)), 2));

        return $this->render('article/show.html.twig', [
            'article' => $articleRepository->findOneBy(['id' => $id]),
            'type_art' => $typeArtRepository->findOneByNom($slug1),
            'art_comps' => $artCompId,
            'marque' => $marqueRepository->findOneByNom($slug2),
            'promo' => $promo,
            'prix_ttc_reduit' => $prixTtcReduit,
            'art_comp_TTC_reduit' => $artCompTTCreduit
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
