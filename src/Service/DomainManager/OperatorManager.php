<?php


namespace App\Service\DomainManager;


use App\Entity\Operator;
use App\Model\DTO\OperatorDTO;
use Doctrine\ORM\EntityManagerInterface;

class OperatorManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param OperatorDTO $operatorDTO
     * @return Operator
     */
    public function create(OperatorDTO $operatorDTO): Operator
    {

        $name = $operatorDTO->firstName;
        $email = $operatorDTO->lastName;
        $phoneNumber = $operatorDTO->phoneNumber;
        $spa = $operatorDTO->spa;
        $treatments = $operatorDTO->treatments;

        $operator = new Operator($name, $email, $spa);
        foreach ($treatments as $t) {
            $operator->addTreatment($t);
        }

        if (!!$phoneNumber) {
            $operator->setPhoneNumber($phoneNumber);
        }

        $this->entityManager->persist($operator);
        $this->entityManager->flush();

        return $operator;
    }
}
