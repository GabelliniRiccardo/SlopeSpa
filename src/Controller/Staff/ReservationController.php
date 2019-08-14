<?php

namespace App\Controller\Staff;

use App\Command\Staff\Reservation\CreateReservation;
use App\Command\Staff\Reservation\DeleteReservation;
use App\Command\Staff\Reservation\EditReservation;
use App\Entity\Reservation;
use App\Exception\ReservationCreateException;
use App\Form\CreateReservationForm;
use App\Form\DeleteReservationForm;
use App\Form\EditReservationForm;
use App\Repository\OperatorRepository;
use App\Repository\ReservationRepository;
use App\Repository\TreatmentRepository;
use App\Service\ReservationQueryService;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/staff/reservation")
 * @IsGranted("ROLE_STAFF")
 */
class ReservationController extends AbstractController
{
    private $commandBus;
    private $entityManager;
    private $translator;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/pastlist/{page}", defaults={"page" : "1"}, name="staff_past_reservation_list", methods={"GET"})
     */
    public function pastReservationsList($page, ReservationRepository $reservationRepository)
    {
        $paginatedReservations = $reservationRepository->findAllPastPaginated($page);

        return $this->render('staff/reservation/pastReservationList.html.twig',
            [
                'pagination' => $paginatedReservations,
                'title' => $this->translator->trans('ReservationList.ListOfReservationsPast'),
                'alert' => true
            ]);
    }

    /**
     * @Route("/futurelist/{page}", defaults={"page" : "1"}, name="staff_future_reservation_list", methods={"GET"})
     */
    public function futureReservationsList($page, ReservationRepository $reservationRepository)
    {
        $paginatedReservations = $reservationRepository->findAllFuturePaginated($page);

        return $this->render('staff/reservation/futureReservationList.html.twig',
            [
                'pagination' => $paginatedReservations,
                'title' => $this->translator->trans('ReservationList.ListOfReservationsFuture'),
                'alert' => false
            ]);
    }

    /**
     * @Route("/create", name="staff_create_reservation",  methods={"GET","POST"})
     */
    public function create(Request $request, TreatmentRepository $treatmentRepository, OperatorRepository $operatorRepository, ReservationQueryService $reservationQueryService)
    {

        $avaiableTreatments = $treatmentRepository->findAll();
        $avaiableOperators = $operatorRepository->findAll();
        $spa = $this->getUser()->getSpa();
        $command = new CreateReservation($spa);
        if ($request->query->has('date')) {
            $dateFromCalendar = new \DateTimeImmutable($request->get('date'));
            $command->reservationDTO->start_time = $dateFromCalendar;
        }

        if ($request->query->has('operatorId')) {
            $operator = $operatorRepository->find($request->get('operatorId'));
            $command->reservationDTO->operator = $operator;
            $avaiableTreatments = $operator->getTreatments();
        }

        $form = $this->createForm(CreateReservationForm::class,
            $command,
            [
                'treatments' => $avaiableTreatments,
                'operators' => $avaiableOperators,
            ]
        );

        $form->handleRequest($request);

        $startTime = $command->reservationDTO->start_time;
        $treatment = $command->reservationDTO->treatment;
        if ($treatment) {
            $interval = new \DateInterval('PT' . $treatment->getDuration() . 'S');
            $endTime = $startTime->add($interval);
            $command->setEndTime($endTime);
        }
        $operator = $command->reservationDTO->operator;

        if ($request->isXmlHttpRequest()) {

            $avaiableTreatments = $reservationQueryService->findAvailableTreatments($startTime, $endTime ?? null, $operator ?? null, null);
            $avaiableOperators = $reservationQueryService->findAvailableOperators($startTime, $endTime ?? null, $treatment ?? null, null);

            $form = $this->createForm(CreateReservationForm::class,
                $command,
                [
                    'treatments' => $avaiableTreatments,
                    'operators' => $avaiableOperators,
                ]);

            $form->handleRequest($request);

            $resetForm = false;
            if (empty($avaiableTreatments) && $operator && $treatment || !in_array($operator, $avaiableOperators) && $operator) {
                $this->addFlash(
                    'alert',
                    $this->translator->trans('Error.OperatorCannotDoTreatment',
                        array(
                            '%operator%' => $operator,
                            '%treatment%' => $treatment,
                            '%startTime%' => $startTime->format('Y-d-m'),
                            '%time%' => $startTime->format('H:i')
                        )));
                $resetForm = true;
            } elseif (empty($avaiableOperators) && $treatment) {
                $this->addFlash('alert',
                    $this->translator->trans('Error.OperatorNotFoundForTreatment',
                        array(
                            '%treatment%' => $treatment,
                            '%startTime%' => $startTime->format('Y-d-m'),
                            '%time%' => $startTime->format('H:i')
                        )));
                $resetForm = true;
            }

            if ($resetForm) {
                $secondCommand = new CreateReservation($spa);
                $secondCommand->reservationDTO->start_time = $command->reservationDTO->start_time;
                $secondCommand->reservationDTO->customer = $command->reservationDTO->customer;
                $form = $this->createForm(CreateReservationForm::class,
                    $secondCommand,
                    [
                        'treatments' => $treatmentRepository->findAll(),
                        'operators' => $operatorRepository->findAll(),
                    ]);
            }

            return $this->render('staff/reservation/ajaxReservationForm.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);
                $this->addFlash('success', 'Reservation created');
                if ($command->reservationDTO->end_time <= new \DateTime('now')) {
                    return $this->redirectToRoute('staff_past_reservation_list');
                } else {
                    return $this->redirectToRoute('staff_future_reservation_list');
                }
            } catch (ReservationCreateException $exception) {
                $this->addFlash('alert', 'The form is not valid');
            }
        }

        return $this->render('staff/reservation/createReservation.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{reservation}", name="staff_edit_reservation",  methods={"GET","POST"})
     */
    public function edit(Reservation $reservation, Request $request, TreatmentRepository $treatmentRepository, OperatorRepository $operatorRepository, ReservationQueryService $reservationQueryService)
    {
        $avaiableTreatments = $treatmentRepository->findAll();
        $avaiableOperators = $operatorRepository->findAll();
        $command = new EditReservation($reservation);
        $form = $this->createForm(EditReservationForm::class,
            $command,
            [
                'treatments' => $avaiableTreatments,
                'operators' => $avaiableOperators,
            ]
        );

        $form->handleRequest($request);

        $startTime = $command->reservationDTO->start_time;
        $treatment = $command->reservationDTO->treatment;
        if ($treatment) {
            $interval = new \DateInterval('PT' . $treatment->getDuration() . 'S');
            $endTime = $startTime->add($interval);
            $command->setEndTime($endTime);
        }
        $operator = $command->reservationDTO->operator;

        if ($request->isXmlHttpRequest()) {

            $avaiableTreatments = $reservationQueryService->findAvailableTreatments($startTime, $endTime ?? null, $operator ?? null, $reservation->getId());
            $avaiableOperators = $reservationQueryService->findAvailableOperators($startTime, $endTime ?? null, $treatment ?? null, $reservation->getId());
            $form = $this->createForm(EditReservationForm::class,
                $command,
                [
                    'treatments' => $avaiableTreatments,
                    'operators' => $avaiableOperators,
                ]);

            $form->handleRequest($request);

            $resetForm = false;
            if (empty($avaiableTreatments) && $operator && $treatment || !in_array($operator, $avaiableOperators) && $operator) {
                $this->addFlash(
                    'alert',
                    $this->translator->trans('Error.OperatorCannotDoTreatment',
                        array(
                            '%operator%' => $operator,
                            '%treatment%' => $treatment,
                            '%startTime%' => $startTime->format('Y-d-m'),
                            '%time%' => $startTime->format('H:i')
                        )));
                $resetForm = true;
            } elseif (empty($avaiableOperators) && $treatment) {
                $this->addFlash('alert',
                    $this->translator->trans('Error.OperatorNotFoundForTreatment',
                        array(
                            '%treatment%' => $treatment,
                            '%startTime%' => $startTime->format('Y-d-m'),
                            '%time%' => $startTime->format('H:i')
                        )));
                $resetForm = true;
            }

            if ($resetForm) {
                $secondCommand = new EditReservation($reservation);
                $secondCommand->reservationDTO->start_time = $command->reservationDTO->start_time;
                $secondCommand->reservationDTO->customer = $command->reservationDTO->customer;
                $form = $this->createForm(EditReservationForm::class,
                    $secondCommand,
                    [
                        'treatments' => $treatmentRepository->findAll(),
                        'operators' => $operatorRepository->findAll(),
                    ]);
            }

            return $this->render('staff/reservation/ajaxReservationForm.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->handle($command);
                $this->addFlash('success', 'Reservation updated');
                if ($command->reservationDTO->end_time <= new \DateTime('now')) {
                    return $this->redirectToRoute('staff_past_reservation_list');
                } else {
                    return $this->redirectToRoute('staff_future_reservation_list');
                }
            } catch (ReservationCreateException $exception) {
                $this->addFlash('alert', 'The form is not valid');
            }
        }

        return $this->render('staff/reservation/editReservation.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{reservation}", name="staff_delete_reservation", methods={"GET","DELETE"})
     */
    public function delete(Reservation $reservation, Request $request)
    {
        $deleteReservationForm = $this->createForm(DeleteReservationForm::class, $reservation,
            [
                'action' => $this->generateUrl('staff_delete_reservation', ['reservation' => $reservation->getId()])
            ]);
        $deleteReservationForm->handleRequest($request);

        if ($deleteReservationForm->isSubmitted() && $deleteReservationForm->isValid()) {
            $command = new DeleteReservation($reservation);
            $this->commandBus->handle($command);
            $this->addFlash('successDelete', 'Reservation deleted');
            if ($reservation->getEndTime() <= new \DateTime('now')) {
                return $this->redirectToRoute('staff_past_reservation_list');
            } else {
                return $this->redirectToRoute('staff_future_reservation_list');
            }
        }

        return $this->render('modal/ReservationDeleteConfirmationModal.html.twig', [
            'deleteReservationForm' => $deleteReservationForm->createView(),
            'reservation' => $reservation
        ]);
    }
}
