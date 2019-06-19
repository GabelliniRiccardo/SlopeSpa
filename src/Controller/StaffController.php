<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/staff")
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
