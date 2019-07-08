<?php


namespace App\Command\Staff\Room;


use App\Entity\Room;
use App\Model\DTO\RoomDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditRoom
{
    /**
     * @var RoomDTO
     * @Assert\Valid
     */
    public $roomDTO;

    public function __construct(Room $room)
    {
        $this->roomDTO = new RoomDTO($room->getSpa());
        $this->roomDTO->id = $room->getId();
        $this->roomDTO->name = $room->getName();
    }
}
