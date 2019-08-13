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
class StatisticsController extends AbstractController
{
    /**
     * @Route("/statistics" , name="staff_statistics", methods={"GET"})
     */
    public function index(OperatorRepository $operatorRepository, ReservationRepository $reservationRepository, TreatmentRepository $treatmentRepository)
    {
        $operators = $operatorRepository->getNumberOfReservationPerOperator();
        $treatments = $treatmentRepository->getNumberOfReservationPerTreatment();
        $reservationsHistory = $reservationRepository->getReservationsHistory();

        return $this->render('staff/statistics.html.twig',
            array(
                'operators' => $operators,
                'reservationsHistory' => $reservationsHistory,
                'treatments' => $treatments
            )
        );
    }
}
