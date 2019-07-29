<?php


namespace App\Command\Staff\Reservation;


use App\Entity\Reservation;
use App\Model\DTO\ReservationDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditReservation
{
    /**
     * @var ReservationDTO
     * @Assert\Valid
     */
    public $reservationDTO;

    public function __construct(Reservation $reservation)
    {
        $this->reservationDTO = new ReservationDTO($reservation->getSpa());
        $this->assignDATAToReservationDTO($reservation);
    }

    private function assignDATAToReservationDTO(Reservation $reservation): void
    {
        $id = $reservation->getId();
        $treatment = $reservation->getTreatment();
        $customer = $reservation->getCustomer();
        $spa = $reservation->getSpa();
        $operator = $reservation->getOperator();
        $startTime = $reservation->getStartTime();
        $duration = $reservation->getDuration();
        $money = $reservation->getMoney();
        $vat = $reservation->getVat();

        $this->reservationDTO->id = $id;
        $this->reservationDTO->treatment = $treatment;
        $this->reservationDTO->customer = $customer;
        $this->reservationDTO->spa = $spa;
        $this->reservationDTO->operator = $operator;
        $this->reservationDTO->start_time = $startTime;
        $this->reservationDTO->duration = $duration;
        $this->reservationDTO->money = $money;
        $this->reservationDTO->vat = $vat;
    }

    /**
     * @param \DateTimeImmutable $endTime
     */
    public function setEndTime(\DateTimeImmutable $endTime)
    {
        $this->reservationDTO->end_time = $endTime;
    }
}
