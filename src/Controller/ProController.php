<?php

namespace App\Controller;

use App\Entity\Pro;
use App\Entity\User;
use App\Form\ProFormType;
use App\Repository\ProRepository;
use App\Service\ManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * IsGranted("ROLE_PRO")
 * @Route("/pro", name="pro_")
 */
class ProController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ProRepository $proRepository): Response
    {
        return $this->render('profile/pro/index.html.twig', [
            'pros' => $proRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(User $user)
    {
        return $this->render('profile/pro/profile/index.html.twig', [
            'controller_name' => 'ProController',
            'user' => $user
        ]);
    }

    /**
     *@Route("/profile/{id}/infos", name="informations")
     * @return void
     */
    public function infosForm(
        User $user,
        Request $request,
        ManagerService $managerService
    ) {
        $pro = new Pro();
        $pro->setUser($user);

        $form = $this->createForm(ProFormType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pro = $form->getData();
            $managerService->persFLush($pro);


            $this->addFlash('success', 'Enregistrement réussi');

            return $this->redirectToRoute('pro_profile', ['id' => $pro->getUser()->getId()]);
        }

        return $this->render('profile/pro/profile/form.html.twig', [
            'formPro' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerService $managerService): Response
    {
        $pro = new Pro();
        $form = $this->createForm(ProFormType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $managerService->persFLush($pro);

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('pro_index');
        }

        return $this->render('profile/pro/new.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Pro $pro): Response
    {
        return $this->render('profile/pro/show.html.twig', [
            'pro' => $pro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pro $pro): Response
    {
        $form = $this->createForm(ProFormType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($this->getUser()->getRoles()[0] === 'ROLE_ADMIN') {
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('pro_index');
            } elseif ($this->getUser()->getRoles()[0] === 'ROLE_PRO') {
                $this->addFlash('success', 'Modification réussi');

                return $this->redirectToRoute('pro_profile', ["id" => $this->getUser()->getId()]);
            }
        }

        return $this->render('profile/pro/edit.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        Pro $pro,
        EntityManagerInterface $emi,
        ManagerService $managerService
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $pro->getId(), $request->request->get('_token'))) {
            $managerService->remFLush($pro);

            $emi->getConnection()->exec('ALTER TABLE pro AUTO_INCREMENT = 1');

            $this->addFlash('success', 'Suppression réussi');
        }

        return $this->redirectToRoute('pro_index');
    }
}
