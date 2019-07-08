<?php


namespace App\Command\Staff\Room;


use App\Entity\SPA;
use App\Model\DTO\RoomDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRoom
{
    /**
     * @var RoomDTO
     * @Assert\Valid
     */
    public $roomDTO;

    public function __construct(SPA $spa)
    {
        $this->roomDTO = new RoomDTO($spa);
    }
}
