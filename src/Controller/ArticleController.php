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
use App\Service\ManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        PromoRepository $promoRepository,
        ProRepository $proRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $today = date('Y-m-d');

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0]=="ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();

            return $this->render('article/index.html.twig', [
                'articles' => $articleRepository->findAll(),
                'marque' => $marqueRepository->findAll(),
                'typeArt' => $typeArtRepository->findAll(),
                'reduc' => $reduc,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'marque' => $marqueRepository->findAll(),
            'typeArt' => $typeArtRepository->findAll(),
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/marque/{slug<[a-zA-z]+>}", name="marque", methods={"GET"})
     */
    public function oneBrandindex(
        string $slug,
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository
    ): Response {

        return $this->render('sell_process/articleSelection.html.twig', [
            'articles' => $articleRepository->findBy(['marque' => $marqueRepository->findOneBy(['nom' => $slug])]),
            'marque' => $marqueRepository->findOneBy(['nom' => $slug])
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        ManagerService $managerService
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $managerService->persFLush($article);

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug1<[a-zA-z]+>}/{slug2<[a-zA-z]+>}/{id}", name="show", methods={"GET"})
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
        $artComps = $artCompRepository->findBy(['artId' => $articleRepository->findOneBy(['id' => $id])]);

        $artCompId = [];
        foreach ($artComps as $artComp) {
            $artCompId[] = $articleRepository->findOneBy(['id' => $artComp->getArtCompId()]);
        }

        if ($this->getUser() !== null && $this->getUser()->getRoles()[0]=="ROLE_PRO") {
            $reduc = $proRepository->findOneBy(['id' => $this->getUser()->getPro()])->getPourcentRemise();
            $prixHt = $articleRepository->findOneBy(['id' => $id])->getPrixHt();
            $prixHtReduit = (round(($prixHt*(1-$reduc/100)), 2)); // arrondit 2 chiffres après la virgule

//            $artCompPrixHT = $articleRepository
//                ->findOneBy(['id' => $artCompRepository->findOneBy(['artId' => $artcomp->getArtId()])])->getPrixHt();
//            $artCompHTreduit = (round(($artCompPrixHT*(1-$reduc/100)), 2));

            return $this->render('article/show.html.twig', [
                'article' => $articleRepository->findOneBy(['id' => $id]),
                'type_art' => $typeArtRepository->findOneBy(['nom' => $slug1]),
                'art_comps' => $artCompId,
                'marque' => $marqueRepository->findOneBy(['nom' => $slug2]),
                'reduc' => $reduc,
                'prix_ht_reduit' => $prixHtReduit,
            ]);
        }

        $promo = $promoRepository->findOneByDate($today)->getPourcentage();
        $prixTtc = $articleRepository->findOneBy(['id' => $id])->getPrixTtc();
        $prixTtcReduit = (round(($prixTtc*(1-$promo/100)), 2)); // arrondit 2 chiffres après la virgule

        return $this->render('article/show.html.twig', [
            'article' => $articleRepository->findOneBy(['id' => $id]),
            'type_art' => $typeArtRepository->findOneBy(['nom' => $slug1]),
            'art_comps' => $artCompId,
            'marque' => $marqueRepository->findOneBy(['nom' => $slug2]),
            'promo' => $promo,
            'prix_ttc_reduit' => $prixTtcReduit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        Article $article,
        ManagerService $managerService
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $managerService->remFLush($article);
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/recherche", name="search", methods={"GET"})
     */
    public function searchArticles(Request $request, ArticleRepository $articleRepository)
    {
        $search = $request->query->get('search');
        $search = trim(str_replace('é', 'e', $search));

        if (preg_match("/reparation/i", $search) == true) {
            $articles = $articleRepository->findBy(['typeArt' => 4]);
        } elseif (preg_match("/batterie/i", $search) == true ||
        preg_match("/vitre/i", $search) == true) {
            $articles = $articleRepository->findBy(['typeArt' => 3]);
        } elseif (preg_match("/coque/i", $search) == true ||
        preg_match("/verre/i", $search) == true ||
        preg_match("/chargeur/i", $search) == true) {
            $articles = $articleRepository->findByTypeAndNom(2, $search);
        } else {
            $articles = $articleRepository->findByNomLike($search);
        }

        return $this->render('search.html.twig', [
            'articles' => $articles
        ]);
    }
}
