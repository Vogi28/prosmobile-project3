<?php

namespace App\Controller;

use App\Entity\CommandePar;
use App\Entity\CommandePro;
use App\Form\CommandeParType;
use App\Form\CommandeProType;
use App\Form\DetailCdePartType;
use App\Form\DetailCdeProType;
use App\Repository\CommandeParRepository;
use App\Repository\CommandeProRepository;
use App\Repository\DetailCdePartRepository;
use App\Repository\DetailCdeProRepository;
use App\Service\ManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande", name="commande_")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/{id}", name="index", methods={"GET"})
     */
    public function index(
        int $id,
        CommandeParRepository $cdeParRepository,
        CommandeProRepository $cdeProRepository
    ): Response {
        // dd($cdeProRepository->findOneByPro($id)->getDetailCdePro()->isEmpty());
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            return $this->render('commande/commande_par/index.html.twig', [
            'commande_pars' => $cdeParRepository->findByParticulier($id),
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            return $this->render('commande/commande_pro/index.html.twig', [
            'commande_pros' => $cdeProRepository->findByPro($id),
            ]);
        }
    }

    /**
     * @Route("/{id}/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerService $managerService): Response
    {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $cdePar = new CommandePar();
            
            $form = $this->createForm(CommandeParType::class, $cdePar);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $managerService->persFLush($cdePar);

                return $this->redirectToRoute('commande_index', ['id' => $cdePar->getParticulier()->getId()]);
            }
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = new CommandePro();

            $form = $this->createForm(CommandeProType::class, $cdePro);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $managerService->persFLush($cdePro);
                
                return $this->redirectToRoute('commande_index', ['id' => $cdePro->getPro()->getId()]);
            }
        }

        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            return $this->render('commande/commande_par/new.html.twig', [
            'commande_par' => $cdePar,
            'form' => $form->createView(),
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            return $this->render('commande/commande_pro/new.html.twig', [
            'commande_pro' => $cdePro,
            'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/detail/{id}", name="show", methods={"GET"})
     */
    
    public function details(
        $id,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro,
        DetailCdePartRepository $dtlCdePartRepository,
        DetailCdeProRepository $dtlCdeProRepository
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
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
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = $cdePro->findOneById($id);

            $articles = $dtlCdeProRepository->findByCommandePro($cdePro->getId());
            $total = 0;

            foreach ($articles as $key => $article) {
                $key;
                $total =+ $article->getTotal();
            }

            return $this->render('commande/commande_pro/show.html.twig', [
            'commande_pro' => $cdePro,
            'details' => $articles,
            'total' => $total
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        int $id,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro,
        DetailCdePartRepository $dtlCdePartRepository,
        DetailCdeProRepository $dtlCdeProRepository
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $dtlCdePar = $dtlCdePartRepository->findOneByCommandePar($id);

            $form = $this->createForm(DetailCdePartType::class, $dtlCdePar);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('commande_index', ['id' => $cdePar->findOneById($id)
                ->getParticulier()->getId()]);
            }
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $dtlCdePro = $dtlCdeProRepository->findOneByCommandePro($id);

            $form = $this->createForm(DetailCdeProType::class, $dtlCdePro);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('commande_index', ['id' => $cdePro->$cdePro->findOneById($id)
                ->getPro()->getId()]);
            }
        }

        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            return $this->render('commande/commande_par/edit.html.twig', [
            'commande_par' => $cdePar,
            'form' => $form->createView(),
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            return $this->render('commande/commande_pro/edit.html.twig', [
            'commande_pro' => $cdePro,
            'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        int $id,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro,
        EntityManagerInterface $emi,
        ManagerService $managerService
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $cdePar = $cdePar->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePar->getId(), $request->request->get('_token'))) {
                $managerService->remFLush($cdePar);
            }

            $emi->getConnection()->exec('ALTER TABLE commande_par AUTO_INCREMENT = 1');
            $emi->getConnection()->exec('ALTER TABLE detail_cde_part AUTO_INCREMENT = 1');

            $this->addFlash('success', 'Suppression réussi');

            return $this->redirectToRoute('commande_index', ['id' =>
            $this->getUser()->getParticulier()->getId()
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = $cdePro->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePro->getId(), $request->request->get('_token'))) {
                $managerService->remFLush($cdePro);
            }

            $this->addFlash('success', 'Suppression réussi');

            $emi->getConnection()->exec('ALTER TABLE commande_pro AUTO_INCREMENT = 1');
            $emi->getConnection()->exec('ALTER TABLE detail_cde_pro AUTO_INCREMENT = 1');

            return $this->redirectToRoute('commande_index', ['id' => $this->getUser()->getPro()->getId()
            ]);
        }
    }

    /**
     * @Route("/{id}/detailDel", name="detail_del", methods={"DELETE"})
     */
    public function detailDel(
        Request $request,
        int $id,
        DetailCdePartRepository $dtlCdePartRepository,
        DetailCdeProRepository $dtlCdeProRepository,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro,
        EntityManagerInterface $emi,
        ManagerService $managerService
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $dtlCdePart = $dtlCdePartRepository->findOneById($id)->getId();
                    dd($dtlCdePart);
            if ($this->isCsrfTokenValid('delete'.$dtlCdePart->getId(), $request->request->get('_token'))) {
                $managerService->remFlush($dtlCdePart);

                $id = $dtlCdePart->getCommandePar()->getId();
                $cdePar = $cdePar->findOneById($id);

                if ($cdePar->getDetailCdePart()->isEmpty() == true) {
                    $managerService->remFlush($cdePar);

                    $emi->getConnection()->exec('ALTER TABLE commande_par AUTO_INCREMENT = 1');
                }
            }

            $this->addFlash('success', 'Suppression réussi');

            $emi->getConnection()->exec('ALTER TABLE detail_cde_part AUTO_INCREMENT = 1');

            return $this->redirectToRoute('commande_index', ['id' => $this->getUser()->getParticulier()->getId()
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $dtlCdePro = $dtlCdeProRepository->findOneById($id);
            
            if ($this->isCsrfTokenValid('delete'.$dtlCdePro->getId(), $request->request->get('_token'))) {
                $managerService->remFlush($dtlCdePro);

                $id = $dtlCdePro->getCommandePro()->getId();
                $cdePro = $cdePro->findOneById($id);
                
                if ($cdePro->getDetailCdePro()->isEmpty() == true) {
                    $managerService->remFlush($cdePro);
                    
                    $emi->getConnection()->exec('ALTER TABLE commande_pro AUTO_INCREMENT = 1');
                }
            }
            
            $this->addFlash('success', 'Suppression réussi');

            $emi->getConnection()->exec('ALTER TABLE detail_cde_pro AUTO_INCREMENT = 1');

            return $this->redirectToRoute('commande_index', ['id' => $this->getUser()->getPro()->getId()
            ]);
        }
    }
}
