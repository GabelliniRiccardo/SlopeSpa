<?php


namespace App\Command\Staff\Room;


use App\Entity\Room;

class DeleteRoom
{
    /**
     * @var Room
     * @Assert\Valid
     */
    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }
}
