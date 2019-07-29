<?php


namespace App\Service\DomainManager;


use App\Entity\Reservation;
use App\Exception\ReservationCreateException;
use App\Model\DTO\ReservationDTO;
use App\Repository\ReservationRepository;
use App\Service\ReservationQueryService;
use Doctrine\ORM\EntityManagerInterface;

class ReservationManager
{
    private $reservationQueryService;
    private $reservationRepository;

    public function __construct(EntityManagerInterface $entityManager, ReservationQueryService $reservationQueryService, ReservationRepository $reservationRepository)
    {
        $this->entityManager = $entityManager;
        $this->reservationQueryService = $reservationQueryService;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param ReservationDTO $reservationDTO
     * @return Reservation
     * @throws \Exception
     */
    public function create(ReservationDTO $reservationDTO): Reservation
    {
        $treatment = $reservationDTO->treatment;
        $startTime = $reservationDTO->start_time;
        $duration = $treatment->getDuration();
        $endTime = $reservationDTO->end_time;
        $customer = $reservationDTO->customer;
        $money = $treatment->getMoney();
        $vat = $treatment->getVat();
        $spa = $reservationDTO->spa;
        $operator = $reservationDTO->operator;

        $availableOperators = $this->reservationQueryService->findAvailableOperators($startTime, $endTime, $treatment, null);
        $availableTreatments = $this->reservationQueryService->findAvailableTreatments($startTime, $endTime, $operator, null);

        // throws exception if someone has changed the form
        if (empty($availableOperators) || empty($availableTreatments) || !in_array($treatment, $availableTreatments) || !in_array($operator, $availableOperators)) {
            throw new ReservationCreateException();
        }

        $reservation = new Reservation($startTime, $endTime, $duration, $money, $treatment, $customer, $vat, $spa, $operator);

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

    /**
     * @param ReservationDTO $reservationDTO
     * @return Reservation
     * @throws \Exception
     */
    public function update(ReservationDTO $reservationDTO): Reservation
    {
        $id = $reservationDTO->id;
        $treatment = $reservationDTO->treatment;
        $customer = $reservationDTO->customer;
//        $spa = $reservationDTO->spa;
        $operator = $reservationDTO->operator;
        $startTime = $reservationDTO->start_time;
        $endTime = $reservationDTO->end_time;
        $duration = $reservationDTO->duration;
        $money = $reservationDTO->money;
        $vat = $reservationDTO->vat;

        $availableOperators = $this->reservationQueryService->findAvailableOperators($startTime, $endTime, $treatment, $id);
        $availableTreatments = $this->reservationQueryService->findAvailableTreatments($startTime, $endTime, $operator, $id);

        // throws exception if someone has changed the form
        if (empty($availableOperators) || empty($availableTreatments) || !in_array($treatment, $availableTreatments) || !in_array($operator, $availableOperators)) {
            throw new ReservationCreateException();
        }

        $reservation = $this->reservationRepository->find($id);

        $reservation->setTreatment($treatment);
        $reservation->setCustomer($customer);
        $reservation->setOperator($operator);
        $reservation->setStartTime($startTime);
        $reservation->setEndTime($endTime);
        $reservation->setDuration($duration);
        $reservation->setMoney($money);
        $reservation->setVat($vat);

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

    /**
     * @param Reservation $reservation
     * @return void
     */
    public function delete(Reservation $reservation): void
    {
        $this->entityManager->remove($reservation);
        $this->entityManager->flush();
    }
}
