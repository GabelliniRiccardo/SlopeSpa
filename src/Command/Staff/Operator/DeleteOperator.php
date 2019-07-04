<?php


namespace App\Command\Staff\Operator;


use App\Entity\Operator;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteOperator
{
    /**
     * @var Operator
     * @Assert\Valid
     */
    public $operator;

    public function __construct(Operator $operator)
    {
        $this->operator = $operator;
    }
}
