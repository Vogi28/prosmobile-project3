<?php

namespace App\Controller;

use App\Entity\DetailCdePart;
use App\Form\DetailCdePartType;
use App\Repository\DetailCdePartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/cde/part")
 */
class DetailCdePartController extends AbstractController
{
    /**
     * @Route("/", name="detail_cde_part_index", methods={"GET"})
     */
    public function index(DetailCdePartRepository $detCdePartRepository): Response
    {
        return $this->render('commande/detail_cde_part/index.html.twig', [
            'detail_cde_parts' => $detCdePartRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_cde_part_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailCdePart = new DetailCdePart();
        $form = $this->createForm(DetailCdePartType::class, $detailCdePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailCdePart);
            $entityManager->flush();

            return $this->redirectToRoute('detail_cde_part_index');
        }

        return $this->render('commande/detail_cde_part/new.html.twig', [
            'detail_cde_part' => $detailCdePart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_cde_part_show", methods={"GET"})
     */
    public function show(DetailCdePart $detailCdePart): Response
    {
        return $this->render('commande/detail_cde_part/show.html.twig', [
            'detail_cde_part' => $detailCdePart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_cde_part_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailCdePart $detailCdePart): Response
    {
        $form = $this->createForm(DetailCdePartType::class, $detailCdePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_cde_part_index');
        }

        return $this->render('commande/detail_cde_part/edit.html.twig', [
            'detail_cde_part' => $detailCdePart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_cde_part_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DetailCdePart $detailCdePart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailCdePart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailCdePart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_cde_part_index');
    }
}
