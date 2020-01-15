<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Pro;
use App\Form\ArticleType;
use App\Repository\ArtCompRepository;
use App\Repository\ArticleRepository;
use App\Repository\PromoRepository;
use App\Repository\ProRepository;
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
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/marque/{id}/{slug<[a-zA-z]+>}", name="article_marque", methods={"GET"})
     */
    public function oneBrandindex(int $id, string $slug, ArticleRepository $articleRepository): Response
    {
        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articleRepository->findBy(['marque' => $id]),
            'marque' => $slug
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
     * @Route("/show/{id}", name="article_show", methods={"GET"})
     */
    public function show(
        Article $article,
        ArticleRepository $articleRepository,
        ArtCompRepository $artCompRepository,
        PromoRepository $promoRepository,
        ProRepository $proRepository
    ): Response {
        $today = date('Y-m-d');
        //dd($this->getUser()->getRoles()[0]);

        if ($this->getUser()->getRoles()[0]=="ROLE_PARTICULIER"){
            $promo = $promoRepository->findOneByDate($today)->getPourcentage();
            $prixTtc = $articleRepository->findOneById(['id' => $article->getId()])->getPrixTtc();
            $prixTtcReduit = (round(($prixTtc*(1-$promo/100)), 2)); // arrondit 2 chiffres après la virgule

            $artComps = $artCompRepository->findByArtId(['artId' => $article->getId()]);
            $artCompId = [];
            foreach ($artComps as $artcomp) {
                $artCompId[] = $articleRepository->findOneBy(['typeArt' => $artcomp->getArtCompId()]);
            }

            return $this->render('article/show.html.twig', [
                'article' => $article,
                'art_comps' => $artCompId,
                'promo' => $promo,
                'prix_ttc_reduit' => $prixTtcReduit,
            ]);
        }
        elseif ($this->getUser()->getRoles()[0]=="ROLE_PRO"){
            $reduc = $proRepository->findOneById($this->getUser()->getPro())->getPourcentRemise();
            $prixHt = $articleRepository->findOneById(['id' => $article->getId()])->getPrixHt();
            $prixHtReduit = (round(($prixHt*(1-$reduc/100)), 2)); // arrondit 2 chiffres après la virgule

            $artComps = $artCompRepository->findByArtId(['artId' => $article->getId()]);
            $artCompId = [];
            foreach ($artComps as $artcomp) {
                $artCompId[] = $articleRepository->findOneBy(['typeArt' => $artcomp->getArtCompId()]);
            }

            return $this->render('article/show.html.twig', [
                'article' => $article,
                'art_comps' => $artCompId,
                'reduc' => $reduc,
                'prix_ht_reduit' => $prixHtReduit,
            ]);
        }

        $artComps = $artCompRepository->findByArtId(['artId' => $article->getId()]);
        $artCompId = [];
        foreach ($artComps as $artcomp) {
            $artCompId[] = $articleRepository->findOneBy(['typeArt' => $artcomp->getArtCompId()]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'art_comps' => $artCompId,
        ]);
    }

    /**
     * @Route("/comp/{id}", name="article_comp", methods={"GET"})
     * @param ArtCompRepository $artCompRepository
     * @param int $id
     * @return Response
     */
    // public function showComp(ArtCompRepository $artCompRepository, int $id): Response
    // {
    //     $artComps = $artCompRepository->findCompByArt($id);
    //     return $this->render('article_show/show.html.twig', [
    //         'art_comps' => $artComps,
    //         'article' => $id,
    //     ]);
    // }

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
