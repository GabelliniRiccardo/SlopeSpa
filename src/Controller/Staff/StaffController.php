<?php

namespace App\Controller\Staff;

use App\Command\Staff\Operator\CreateOperator;
use App\Entity\SPA;
use App\Form\CreateOperatorForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff")
 * @IsGranted("ROLE_STAFF")
 */

class StaffController extends AbstractController
{
    /**
     * @Route("/dashboard" , name="staff_dashboard", methods={"GET"})
     */
    public function index()
    {
        return $this->render('staff/index.html.twig');
    }
}
