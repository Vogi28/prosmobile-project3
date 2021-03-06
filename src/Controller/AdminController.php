<?php

namespace App\Controller;

use App\Form\CommandeParType;
use App\Form\CommandeProType;
use App\Repository\MarqueRepository;
use App\Repository\PromoRepository;
use App\Repository\ProRepository;
use App\Repository\TypeArtRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeParRepository;
use App\Repository\CommandeProRepository;
use App\Repository\ParticulierRepository;
use App\Repository\DetailCdeProRepository;
use App\Repository\DetailCdePartRepository;
use App\Service\ManagerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     *
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/commande", name="commande_index", methods={"GET"})
     */
    public function cdeIndex(
        CommandeParRepository $cdeParRepository,
        CommandeProRepository $cdeProRepository,
        ParticulierRepository $particulier,
        ProRepository $pro
    ): Response {
            $cde = $cdeParRepository->findAll();
            $cdePro = $cdeProRepository->findAll();
            $range = count($cdePro);
        for ($i=0; $i < $range; $i++) {
            $cde[] = $cdePro[$i];
        }

        return $this->render('commande/index.html.twig', [
            'commandes' => $cde,
            'particuliers' => $particulier->findAll(),
            'pros' => $pro->findAll()
            ]);
    }

    /**
     * @Route("/commande/{id}/{role}", name="commande_detail", methods={"GET"})
     */

    public function details(
        int $id,
        string $role,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro,
        DetailCdePartRepository $dtlCdePartRepository,
        DetailCdeProRepository $dtlCdeProRepository
    ): Response {

        if ($role === 'particulier') {
            $cdePar = $cdePar->findOneById($id);

            $articles = $dtlCdePartRepository->findByCommandePar($cdePar->getId());
            $total = 0;

            foreach ($articles as $key => $article) {
                $key;
                $total += $article->getTotal();
            }
            return $this->render('commande/commande_par/show.html.twig', [
                'commande_par' => $cdePar,
                'details' => $articles,
                'total' => $total
            ]);
        } elseif ($role === 'pro') {
            $cdePro = $cdePro->findOneById($id);

            $articles = $dtlCdeProRepository->findByCommandePro($cdePro->getId());
            $total = 0;

            foreach ($articles as $key => $article) {
                $key;
                $total += $article->getTotal();
            }

            return $this->render('commande/commande_pro/show.html.twig', [
                'commande_pro' => $cdePro,
                'details' => $articles,
                'total' => $total
            ]);
        }
    }

    /**
     * @Route("/commande/{id}/{role}/edit", name="commande_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        int $id,
        string $role,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro
    ): Response {
        if ($role === 'particulier') {
            $cdePar = $cdePar->findOneById($id);

            $form = $this->createForm(CommandeParType::class, $cdePar);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('admin_commande_index');
            }
        } elseif ($role === 'pro') {
            $cdePro = $cdePro->findOneById($id);

            $form = $this->createForm(CommandeProType::class, $cdePro);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('admin_commande_index');
            }
        }

        if ($role === 'particulier') {
            return $this->render('commande/commande_par/edit.html.twig', [
            'commande_par' => $cdePar,
            'form' => $form->createView(),
            ]);
        } elseif ($role === 'pro') {
            return $this->render('commande/commande_pro/edit.html.twig', [
            'commande_pro' => $cdePro,
            'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/commande/{id}/{role}", name="commande_delete", methods={"DELETE"})
     */
    public function deleteCde(
        Request $request,
        int $id,
        string $role,
        UserRepository $userRepository,
        ManagerService $managerService,
        EntityManagerInterface $emi
    ): Response {
        if ($role === 'particulier') {
            $userPar = $userRepository->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$userPar->getId(), $request->request->get('_token'))) {
                $managerService->remFlush($userPar);

                $emi->getConnection()->exec('ALTER TABLE commande_par AUTO_INCREMENT = 1');
            }
        } elseif ($role === 'pro') {
            $userPro = $userRepository->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$userPro->getId(), $request->request->get('_token'))) {
                $managerService->remFlush($userPro);

                $emi->getConnection()->exec('ALTER TABLE commande_pro AUTO_INCREMENT = 1');
            }
        }

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute('admin_commande_index');
    }

    /**
     *@Route("/article", name="article_index")
     */
    public function articleIndex(
        ArticleRepository $articleRepository,
        MarqueRepository $marqueRepository,
        PromoRepository $promoRepository,
        TypeArtRepository $typeArtRepository
    ): Response {
        $today = date('Y-m-d');
        $promo = $promoRepository->findOneByDate($today)->getPourcentage();

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'marque' => $marqueRepository->findAll(),
            'typeArt' => $typeArtRepository->findAll(),
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUser(
        Request $request,
        int $id,
        UserRepository $userRepository,
        ManagerService $managerService,
        EntityManagerInterface $emi
    ): Response {
            $user = $userRepository->findOneById($id);

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            if ($user->getRoles()[0] === 'ROLE_PARTICULIER') {
                $path = 'particulier_index';
            } else {
                $path = 'pro_index';
            }

            $managerService->remFlush($user);

            if ($user->getRoles()[0] === 'ROLE_PARTICULIER') {
                $emi->getConnection()->exec('ALTER TABLE particulier AUTO_INCREMENT = 1');
            } else {
                $emi->getConnection()->exec('ALTER TABLE pro AUTO_INCREMENT = 1');
            }


            $emi->getConnection()->exec('ALTER TABLE user AUTO_INCREMENT = 1');
        }

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute($path);
    }
}
