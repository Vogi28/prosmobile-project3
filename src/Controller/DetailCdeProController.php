<?php

namespace App\Controller;

use App\Entity\DetailCdePro;
use App\Form\DetailCdeProType;
use App\Repository\DetailCdeProRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/cde/pro")
 */
class DetailCdeProController extends AbstractController
{
    /**
     * @Route("/", name="detail_cde_pro_index", methods={"GET"})
     */
    public function index(DetailCdeProRepository $detCdeProRepository): Response
    {
        return $this->render('detail_cde_pro/index.html.twig', [
            'detail_cde_pros' => $detCdeProRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_cde_pro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailCdePro = new DetailCdePro();
        $form = $this->createForm(DetailCdeProType::class, $detailCdePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailCdePro);
            $entityManager->flush();

            return $this->redirectToRoute('detail_cde_pro_index');
        }

        return $this->render('detail_cde_pro/new.html.twig', [
            'detail_cde_pro' => $detailCdePro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_cde_pro_show", methods={"GET"})
     */
    public function show(DetailCdePro $detailCdePro): Response
    {
        return $this->render('detail_cde_pro/show.html.twig', [
            'detail_cde_pro' => $detailCdePro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_cde_pro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailCdePro $detailCdePro): Response
    {
        $form = $this->createForm(DetailCdeProType::class, $detailCdePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_cde_pro_index');
        }

        return $this->render('detail_cde_pro/edit.html.twig', [
            'detail_cde_pro' => $detailCdePro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_cde_pro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DetailCdePro $detailCdePro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailCdePro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailCdePro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_cde_pro_index');
    }
}
