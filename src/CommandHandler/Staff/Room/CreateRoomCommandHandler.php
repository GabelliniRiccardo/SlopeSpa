<?php


namespace App\CommandHandler\Staff\Room;


use App\Command\Staff\Room\CreateRoom;
use App\Service\DomainManager\RoomManager;

class CreateRoomCommandHandler
{
    protected $roomManager;

    public function __construct(RoomManager $roomManager)
    {
        $this->roomManager = $roomManager;
    }

    public function handle(CreateRoom $command): void
    {
        $this->roomManager->create($command->roomDTO);
    }
}
