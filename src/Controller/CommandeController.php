<?php

namespace App\Controller;

use App\Entity\CommandePar;
use App\Entity\CommandePro;
use App\Form\CommandeParType;
use App\Form\CommandeProType;
use App\Repository\CommandeParRepository;
use App\Repository\CommandeProRepository;
use App\Repository\DetailCdePartRepository;
use App\Repository\DetailCdeProRepository;
use App\Repository\ParticulierRepository;
use App\Repository\ProRepository;
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
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $cdePar = new CommandePar();
            
            $form = $this->createForm(CommandeParType::class, $cdePar);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cdePar);
                $entityManager->flush();

                return $this->redirectToRoute('commande_index');
            }
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = new CommandePro();

            $form = $this->createForm(CommandeProType::class, $cdePro);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cdePro);
                $entityManager->flush();

                return $this->redirectToRoute('commande_index');
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
            return $this->render('commande/commande_par/show.html.twig', [
            'commande_par' => $cdePar,
            'details' => $dtlCdePartRepository->findByCommandePar($cdePar->getId())
            ]);
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = $cdePro->findOneById($id);
            return $this->render('commande/commande_pro/show.html.twig', [
            'commande_pro' => $cdePro,
            'details' => $dtlCdeProRepository->findByCommandePro($cdePro->getId())

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
        CommandeProRepository $cdePro
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $cdePar = $cdePar->findOneById($id);

            $form = $this->createForm(CommandeParType::class, $cdePar);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('commande_index', ['id' => $cdePar->getParticulier()->getId()]);
            }
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = $cdePro->findOneById($id);

            $form = $this->createForm(CommandeProType::class, $cdePro);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('commande_index', ['id' => $cdePro->getPro()->getId()]);
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
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        int $id,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro
    ): Response {
        if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
            $cdePar = $cdePar->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePar->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($cdePar);
                $entityManager->flush();
            }
        } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
            $cdePro = $cdePro->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePro->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($cdePro);
                $entityManager->flush();
            }
        }

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute('commande_index');
    }
}
