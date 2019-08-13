<?php


namespace App\Controller\Staff;


use App\Command\Staff\Reservation\DeleteReservation;
use App\Entity\Reservation;
use App\Repository\OperatorRepository;
use App\Repository\ReservationRepository;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/staff/calendar")
 * @IsGranted("ROLE_STAFF")
 */
class CalendarController extends AbstractController
{

    private $commandBus;
    private $translator;

    public function __construct(CommandBus $commandBus, TranslatorInterface $translator)
    {
        $this->commandBus = $commandBus;
        $this->translator = $translator;
    }

    /**
     * @Route("/" , name="staff_calendar", methods={"GET"})
     */
    public function index()
    {
        return $this->render('staff/calendar/calendar.html.twig');
    }

    /**
     * @Route("/reservations/" , name="staff_calendar_today", methods={"GET"})
     */
    public function today(Request $request, ReservationRepository $reservationRepository)
    {
        $date = new \DateTime($request->get('date'));
        $reservations = $reservationRepository->getReservationsOfDay($date);

        return new JsonResponse($reservations);
    }

    /**
     * @Route("/operators/" , name="staff_calendar_operators", methods={"GET"})
     */
    public function operators(OperatorRepository $operatorRepository)
    {
        $operators = $operatorRepository->getIdFirstNameAndLastNameOfAllOperators();

        return new JsonResponse($operators);
    }

    /**
     * @Route("/reservation/delete/{reservation}", name="staff_calendar_delete_reservation", methods={"DELETE"})
     */
    public function delete(Reservation $reservation, Request $request)
    {
        $message = $this->translator->trans('Calendar.DeleteMessage.Error');
        $response = new Response($message);
        $response->setStatusCode(404);
        if ($request->isXmlHttpRequest()) {
            $command = new DeleteReservation($reservation);
            $this->commandBus->handle($command);
            $message = $this->translator->trans('Calendar.DeleteMessage.Success');
            $response = new Response($message);
            $response->setStatusCode(200);
        }

        return $response;
    }
}
