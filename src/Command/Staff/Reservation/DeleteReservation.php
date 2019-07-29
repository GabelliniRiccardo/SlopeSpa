<?php


namespace App\Command\Staff\Reservation;


use App\Entity\Reservation;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteReservation
{
    /**
     * @var Reservation
     * @Assert\Valid
     */
    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
}
