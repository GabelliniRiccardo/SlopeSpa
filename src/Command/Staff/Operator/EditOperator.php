<?php


namespace App\Command\Staff\Operator;


use App\Entity\Operator;
use App\Entity\SPA;
use App\Model\DTO\OperatorDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditOperator
{
    /**
     * @var OperatorDTO
     * @Assert\Valid
     */
    public $operatorDTO;

    public function __construct(Operator $operator)
    {
        $this->operatorDTO = new OperatorDTO($operator->getSpa());
        $this->assignDATAToOperatorDTO($operator);
    }

    private function assignDATAToOperatorDTO(Operator $operator): void
    {
        $id = $operator->getId();
        $name = $operator->getFirstName();
        $lastName = $operator->getLastName();
        $phoneNumber = $operator->getPhoneNumber();
        $spa = $operator->getSpa();
        $treatments = $operator->getTreatments()->toArray();

        $this->operatorDTO->id = $id;
        $this->operatorDTO->firstName = $name;
        $this->operatorDTO->lastName = $lastName;
        $this->operatorDTO->phoneNumber = $phoneNumber;
        $this->operatorDTO->spa = $spa;
        $this->operatorDTO->treatments = $treatments;
    }
}
