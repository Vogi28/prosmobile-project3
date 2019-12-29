<?php

namespace App\Controller;

use App\Entity\Particulier;
use App\Entity\User;
use App\Form\ParticulierFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * IsGranted("ROLE_PARTICULIER")
 * @Route("/particulier", name="particulier_")
 */
class ParticulierController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(User $user)
    {
    
        return $this->render('particulier/index.html.twig', [
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

            return $this->redirectToRoute('particulier_profile', ['id' => $particulier->getUser()->getId()]);
        }

        return $this->render('particulier/form.html.twig', [
            'formParticulier' => $form->createView()
        ]);
    }
}
