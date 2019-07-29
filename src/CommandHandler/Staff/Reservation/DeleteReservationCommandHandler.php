<?php


namespace App\CommandHandler\Staff\Reservation;


use App\Command\Staff\Reservation\DeleteReservation;
use App\Service\DomainManager\ReservationManager;

class DeleteReservationCommandHandler
{
    protected $reservationManager;

    public function __construct(ReservationManager $reservationManager)
    {
        $this->reservationManager = $reservationManager;
    }

    public function handle(DeleteReservation $command): void
    {
        $this->reservationManager->delete($command->reservation);
    }
}
