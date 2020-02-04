<?php

namespace App\Controller;

use App\Entity\Spec;
use App\Form\SpecType;
use App\Repository\SpecRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spec")
 */
class SpecController extends AbstractController
{
    /**
     * @Route("/", name="spec_index", methods={"GET"})
     */
    public function index(SpecRepository $specRepository): Response
    {
        return $this->render('spec/index.html.twig', [
            'specs' => $specRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="spec_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $spec = new Spec();
        $form = $this->createForm(SpecType::class, $spec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spec);
            $entityManager->flush();

            return $this->redirectToRoute('spec_index');
        }

        return $this->render('spec/new.html.twig', [
            'spec' => $spec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spec_show", methods={"GET"})
     */
    public function show(Spec $spec): Response
    {
        return $this->render('spec/show.html.twig', [
            'spec' => $spec,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spec_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Spec $spec): Response
    {
        $form = $this->createForm(SpecType::class, $spec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spec_index');
        }

        return $this->render('spec/edit.html.twig', [
            'spec' => $spec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spec_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Spec $spec, EntityManagerInterface $emi): Response
    {
        if ($this->isCsrfTokenValid('delete' . $spec->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spec);
            $entityManager->flush();

            $emi->getConnection()->exec('ALTER TABLE spec AUTO_INCREMENT = 1');
        }

        return $this->redirectToRoute('spec_index');
    }
}
