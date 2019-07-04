<?php


namespace App\Model\DTO;


use App\Entity\Operator;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\SPA;
use App\Objects\Money;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class TreatmentDTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @var Money
     */
    public $money;

    /**
     * @Assert\NotBlank
     * @var integer
     */
    public $duration;

    /**
     * @Assert\NotBlank
     * @var float
     */
    public $vat;

    /**
     * Collection|Operator[]
     */
    public $operators;

    /**
     * @var Collection|Room[]
     */
    public $rooms;

    /**
     * @var Collection|Reservation[]
     */
    public $reservations;

    /**
     * @var SPA
     */
    public $spa;

    /**
     * TreatmentDTO constructor.
     * @param SPA $spa
     */
    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
