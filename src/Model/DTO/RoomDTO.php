<?php


namespace App\Model\DTO;

use App\Entity\SPA;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class RoomDTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     * )
     * @var string
     */
    public $name;

    /**
     * @var SPA
     */
    public $spa;

    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
