<?php

namespace App\Controller;

use App\Entity\CommandePro;
use App\Form\CommandeProType;
use App\Repository\CommandeProRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/pro")
 */
class CommandeProController extends AbstractController
{
    /**
     * @Route("/", name="commande_pro_index", methods={"GET"})
     */
    public function index(CommandeProRepository $cdeProRepository): Response
    {
        return $this->render('commande/commande_pro/index.html.twig', [
            'commande_pros' => $cdeProRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_pro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandePro = new CommandePro();
        $form = $this->createForm(CommandeProType::class, $commandePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandePro);
            $entityManager->flush();

            return $this->redirectToRoute('commande_pro_index');
        }

        return $this->render('commande/commande_pro/new.html.twig', [
            'commande_pro' => $commandePro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_pro_show", methods={"GET"})
     */
    public function show(CommandePro $commandePro): Response
    {
        return $this->render('commande/commande_pro/show.html.twig', [
            'commande_pro' => $commandePro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_pro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandePro $commandePro): Response
    {
        $form = $this->createForm(CommandeProType::class, $commandePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_pro_index');
        }

        return $this->render('commande/commande_pro/edit.html.twig', [
            'commande_pro' => $commandePro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_pro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandePro $commandePro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandePro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandePro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_pro_index');
    }
}
