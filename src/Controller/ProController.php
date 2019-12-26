<?php

namespace App\Controller;

use App\Entity\Pro;
use App\Entity\User;
use App\Form\ProFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * IsGranted("ROLE_PRO")
 * @Route("/pro", name="pro_")
 */
class ProController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(User $user)
    {
        return $this->render('pro/index.html.twig', [
            'controller_name' => 'ProController',
            'user' => $user
        ]);
    }

    /**
     *@Route("/profile/{id}/infos", name="informations")
     * @return void
     */
    public function infosForm(User $user, Request $request, EntityManagerInterface $em)
    {
        $pro = new Pro();
        $pro->setUser($user);

        $form = $this->createForm(ProFormType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pro = $form->getData();
            $em->persist($pro);
            $em->flush();

            return $this->redirectToRoute('pro_profile', ['id' => $pro->getUser()->getId()]);
        }

        return $this->render('pro/form.html.twig', [
            'formPro' => $form->createView()
        ]);
    }
}
