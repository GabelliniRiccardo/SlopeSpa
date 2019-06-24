<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff")
 *  @IsGranted("ROLE_STAFF")
 */

class StaffController extends AbstractController
{
    /**
     * @Route("/dashboard", name="staff_dashboard")
     */
    public function index()
    {
        return $this->render('staff/index.html.twig', [
            'controller_name' => 'StaffController',
        ]);
    }
}
