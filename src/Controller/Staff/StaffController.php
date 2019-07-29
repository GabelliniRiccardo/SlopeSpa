<?php

namespace App\Controller\Staff;

use App\Repository\OperatorRepository;
use App\Repository\ReservationRepository;
use App\Repository\TreatmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(OperatorRepository $operatorRepository, ReservationRepository $reservationRepository, TreatmentRepository $treatmentRepository)
    {
        $operators = $operatorRepository->getNumberOfReservationPerOperator();
        $treatments = $treatmentRepository->getNumberOfReservationPerTreatment();
        $reservationsHistory = $reservationRepository->getReservationsHistory();

        return $this->render('staff/index.html.twig',
            array(
                'operators' => $operators,
                'reservationsHistory' => $reservationsHistory,
                'treatments' => $treatments
            )
        );
    }
}
