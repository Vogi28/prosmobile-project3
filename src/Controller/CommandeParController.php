<?php

namespace App\Controller;

use App\Entity\CommandePar;
use App\Form\CommandeParType;
use App\Repository\CommandeParRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/particulier")
 */
class CommandeParController extends AbstractController
{
    /**
     * @Route("/", name="commande_par_index", methods={"GET"})
     */
    public function index(CommandeParRepository $cdeParRepository): Response
    {
        return $this->render('commande/commande_par/index.html.twig', [
            'commande_pars' => $cdeParRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_par_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandePar = new CommandePar();
        $form = $this->createForm(CommandeParType::class, $commandePar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandePar);
            $entityManager->flush();

            return $this->redirectToRoute('commande_par_index');
        }

        return $this->render('commande/commande_par/new.html.twig', [
            'commande_par' => $commandePar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_par_show", methods={"GET"})
     */
    public function show(CommandePar $commandePar): Response
    {
        return $this->render('commande/commande_par/show.html.twig', [
            'commande_par' => $commandePar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_par_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandePar $commandePar): Response
    {
        $form = $this->createForm(CommandeParType::class, $commandePar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_par_index');
        }

        return $this->render('commande/commande_par/edit.html.twig', [
            'commande_par' => $commandePar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_par_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandePar $commandePar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandePar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandePar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_par_index');
    }
}
