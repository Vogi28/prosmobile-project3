<?php

namespace App\Controller;

use App\Entity\CommandePar;
use App\Entity\CommandePro;
use App\Form\CommandeParType;
use App\Form\CommandeProType;
use App\Repository\ProRepository;
use App\Repository\CommandeParRepository;
use App\Repository\CommandeProRepository;
use App\Repository\ParticulierRepository;
use App\Repository\DetailCdeProRepository;
use App\Repository\DetailCdePartRepository;
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
            return $this->render('commande/commande_par/show.html.twig', [
            'commande_par' => $cdePar,
            'details' => $dtlCdePartRepository->findByCommandePar($cdePar->getId())
            ]);
        } elseif ($role === 'pro') {
            $cdePro = $cdePro->findOneById($id);
            return $this->render('commande/commande_pro/show.html.twig', [
            'commande_pro' => $cdePro,
            'details' => $dtlCdeProRepository->findByCommandePro($cdePro->getId())

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
    public function delete(
        Request $request,
        int $id,
        string $role,
        CommandeParRepository $cdePar,
        CommandeProRepository $cdePro
    ): Response {
        if ($role === 'particulier') {
            $cdePar = $cdePar->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePar->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($cdePar);
                $entityManager->flush();
            }
        } elseif ($role === 'pro') {
            $cdePro = $cdePro->findOneById($id);

            if ($this->isCsrfTokenValid('delete'.$cdePro->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($cdePro);
                $entityManager->flush();
            }
        }

        $this->addFlash('success', 'Suppression réussi');

        return $this->redirectToRoute('admin_commande_index');
    }
}
