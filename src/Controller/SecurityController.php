<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPasswordType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManager;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        MailerService $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            if ($form->get('pros')->getData() === true) {
                $user->setRoles(['ROLE_PRO']);
            } else {
                $user->setRoles(['ROLE_PARTICULIER']);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Enregistrement réussi');

            $mailer->sendRegNotif($user->getEmail());
            
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] === 'ROLE_PARTICULIER') {
                return $this->redirectToRoute("particulier_profile", ["id" => $this->getUser()->getId()]);
            } elseif ($this->getUser()->getRoles()[0] == 'ROLE_PRO') {
                return $this->redirectToRoute('pro_profile', ['id' => $this->getUser()->getId()]);
            } elseif ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
                return $this->redirectToRoute('admin_index');
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/password/{id}", name="changer_mdp")
     */
    public function changePassword(
        User $user,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $emi
    ) {
        
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            ));

            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', 'Changement de mot de passe réussi');
            
            if ($user->getRoles()[0] === 'ROLE_PARTICULIER') {
                return $this->redirectToRoute("particulier_profile", ["id" => $user->getId()]);
            } elseif ($user->getRoles()[0] == 'ROLE_PRO') {
                 return $this->redirectToRoute('pro_profile', ['id' => $user->getID()]);
            }
        }

        return $this->render('security/changePass.html.twig', [
            'formPass' => $form->createView()
        ]);
    }
}
