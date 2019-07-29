<?php


namespace App\Model\DTO;


use App\Entity\Customer;
use App\Entity\Operator;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationDTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var \DateTimeImmutable
     */
    public $start_time;

    /**
     * @var \DateTimeImmutable
     */
    public $end_time;

    /**
     * @var integer
     */
    public $duration;

    /**
     * @var Money
     */
    public $money;

    /**
     * @var Treatment
     */
    public $treatment;

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var float
     */
    public $vat;

    /**
     * @var SPA
     */
    public $spa;

    /**
     * @var Operator
     */
    public $operator;

    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
