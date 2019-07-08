<?php


namespace App\CommandHandler\Staff\Room;


use App\Command\Staff\Room\EditRoom;
use App\Service\DomainManager\RoomManager;

class EditRoomCommandHandler
{
    protected $roomManager;

    public function __construct(RoomManager $roomManager)
    {
        $this->roomManager = $roomManager;
    }

    public function handle(EditRoom $command): void
    {
        $this->roomManager->update($command->roomDTO);
    }
}
