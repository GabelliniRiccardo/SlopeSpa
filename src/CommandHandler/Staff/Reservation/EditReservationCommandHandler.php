<?php


namespace App\CommandHandler\Staff\Reservation;


use App\Command\Staff\Reservation\EditReservation;
use App\Service\DomainManager\ReservationManager;

class EditReservationCommandHandler
{
    protected $reservationManager;

    public function __construct(ReservationManager $reservationManager)
    {
        $this->reservationManager = $reservationManager;
    }

    public function handle(EditReservation $command): void
    {
        $this->reservationManager->update($command->reservationDTO);
    }
}
