<?php

namespace App\Controller;

use App\Entity\ArtComp;
use App\Form\ArtCompType;
use App\Repository\ArtCompRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/art/comp")
 */
class ArtCompController extends AbstractController
{
    /**
     * @Route("/", name="art_comp_index", methods={"GET"})
     */
    public function index(ArtCompRepository $artCompRepository): Response
    {
        return $this->render('art_comp/index.html.twig', [
            'art_comps' => $artCompRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="art_comp_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artComp = new ArtComp();
        $form = $this->createForm(ArtCompType::class, $artComp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artComp);
            $entityManager->flush();

            return $this->redirectToRoute('art_comp_index');
        }

        return $this->render('art_comp/new.html.twig', [
            'art_comp' => $artComp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="art_comp_show", methods={"GET"})
     */
    public function show(ArtComp $artComp): Response
    {
        return $this->render('art_comp/show.html.twig', [
            'art_comp' => $artComp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="art_comp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArtComp $artComp): Response
    {
        $form = $this->createForm(ArtCompType::class, $artComp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('art_comp_index');
        }

        return $this->render('art_comp/edit.html.twig', [
            'art_comp' => $artComp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="art_comp_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArtComp $artComp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artComp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artComp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('art_comp_index');
    }
}
