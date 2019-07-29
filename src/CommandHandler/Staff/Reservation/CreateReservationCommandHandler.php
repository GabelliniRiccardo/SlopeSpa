<?php


namespace App\CommandHandler\Staff\Reservation;


use App\Command\Staff\Reservation\CreateReservation;
use App\Service\DomainManager\ReservationManager;

class CreateReservationCommandHandler
{
    protected $reservationManager;

    public function __construct(ReservationManager $reservationManager)
    {
        $this->reservationManager = $reservationManager;
    }

    public function handle(CreateReservation $command): void
    {
        $this->reservationManager->create($command->reservationDTO);
    }
}
