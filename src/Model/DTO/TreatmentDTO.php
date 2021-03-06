<?php


namespace App\Model\DTO;


use App\Entity\Operator;
use App\Entity\Reservation;
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
     *      max = 60,
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
        $this->money = new Money(0);
    }

    public function getPrice(){
        return $this->money->getValue();
    }

    public function getCurrency(){
        return $this->money->getCurrency();
    }
}
