<?php


namespace App\CommandHandler\Staff\Room;


use App\Command\Staff\Room\DeleteRoom;
use App\Service\DomainManager\RoomManager;

class DeleteRoomCommandHandler
{
    protected $roomManager;

    public function __construct(RoomManager $roomManager)
    {
        $this->roomManager = $roomManager;
    }

    public function handle(DeleteRoom $command): void
    {
        $this->roomManager->delete($command->room);
    }
}
