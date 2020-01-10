<?php

namespace App\Controller;

use App\Entity\Particulier;
use App\Entity\User;
use App\Form\ParticulierFormType;
use App\Repository\ParticulierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * IsGranted("ROLE_PARTICULIER")
 * @Route("/particulier", name="particulier_")
 */
class ParticulierController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ParticulierRepository $partiRepository)
    {
        return $this->render('profile/particulier/index.html.twig', [
            'particuliers' => $partiRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(User $user)
    {
    
        return $this->render('profile/particulier/profile/index.html.twig', [
            'controller_name' => 'ParticulierController',
            'user' => $user
        ]);
    }

    /**
     *@Route("/profile/{id}/infos", name="informations")
     * @return void
     */
    public function infosForm(User $user, Request $request, EntityManagerInterface $emi)
    {
        $particulier = new Particulier();
        $particulier->setUser($user);

        $form = $this->createForm(ParticulierFormType::class, $particulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $particulier = $form->getData();
            $emi->persist($particulier);
            $emi->flush();

            $this->addFlash('success', 'Enregistrement réussi');

            return $this->redirectToRoute('particulier_profile', ['id' => $particulier->getUser()->getId()]);
        }

        return $this->render('profile/particulier/profile/form.html.twig', [
            'formParticulier' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, User $user): Response
    {
        dd($user);
        $particulier = new Particulier();
        $form = $this->createForm(ParticulierFormType::class, $particulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($particulier);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('particulier_index');
        }

        return $this->render('profile/particulier/new.html.twig', [
            'particulier' => $particulier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Particulier $particulier): Response
    {
        return $this->render('profile/particulier/show.html.twig', [
            'particulier' => $particulier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Particulier $particulier): Response
    {
        $form = $this->createForm(ParticulierFormType::class, $particulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($this->getUser()->getRoles()[0] === 'ROLE_ADMIN') {
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('particulier_index');
            } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('particulier_profile', ["id" => $this->getUser()->getId()]);
            }
        }

        return $this->render('profile/particulier/edit.html.twig', [
            'particulier' => $particulier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Particulier $particulier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$particulier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($particulier);
            $entityManager->flush();

            $this->addFlash('success', 'Suppression réussi');
        }

        return $this->redirectToRoute('particulier_index');
    }
}
