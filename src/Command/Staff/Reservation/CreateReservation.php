<?php


namespace App\Command\Staff\Reservation;

use App\Entity\SPA;
use App\Model\DTO\ReservationDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateReservation
{
    /**
     * @var ReservationDTO
     * @Assert\Valid
     */
    public $reservationDTO;

    public function __construct(SPA $spa)
    {
        $this->reservationDTO = new ReservationDTO($spa);
    }

    /**
     * @param \DateTimeImmutable $endTime
     */
    public function setEndTime(\DateTimeImmutable $endTime)
    {
        $this->reservationDTO->end_time = $endTime;
    }
}
