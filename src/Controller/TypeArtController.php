<?php

namespace App\Controller;

use App\Entity\TypeArt;
use App\Form\TypeArtType;
use App\Repository\TypeArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/art")
 */
class TypeArtController extends AbstractController
{
    /**
     * @Route("/", name="type_art_index", methods={"GET"})
     */
    public function index(TypeArtRepository $typeArtRepository): Response
    {
        return $this->render('type_art/index.html.twig', [
            'type_arts' => $typeArtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_art_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeArt = new TypeArt();
        $form = $this->createForm(TypeArtType::class, $typeArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeArt);
            $entityManager->flush();

            return $this->redirectToRoute('type_art_index');
        }

        return $this->render('type_art/new.html.twig', [
            'type_art' => $typeArt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_art_show", methods={"GET"})
     */
    public function show(TypeArt $typeArt): Response
    {
        return $this->render('type_art/show.html.twig', [
            'type_art' => $typeArt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_art_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeArt $typeArt): Response
    {
        $form = $this->createForm(TypeArtType::class, $typeArt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_art_index');
        }

        return $this->render('type_art/edit.html.twig', [
            'type_art' => $typeArt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_art_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeArt $typeArt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeArt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeArt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_art_index');
    }
}
