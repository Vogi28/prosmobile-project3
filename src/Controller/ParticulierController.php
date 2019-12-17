<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * IsGranted("ROLE_PARTICULIER")
 */
class ParticulierController extends AbstractController
{
    /**
     * @Route("/particulier", name="particulier")
     */
    public function index()
    {
        return $this->render('particulier/index.html.twig', [
            'controller_name' => 'ParticulierController',
        ]);
    }
}
