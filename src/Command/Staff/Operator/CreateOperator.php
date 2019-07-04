<?php


namespace App\Command\Staff\Operator;


use App\Entity\SPA;
use App\Model\DTO\OperatorDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateOperator
{
    /**
     * @var OperatorDTO
     * @Assert\Valid
     */
    public $operatorDTO;

    public function __construct(SPA $spa)
    {
        $this->operatorDTO = new OperatorDTO($spa);
    }
}
