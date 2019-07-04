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

    /**
     * @param OperatorDTO $operatorDTO
     * @return Operator
     */
    public function update(OperatorDTO $operatorDTO): Operator
    {
        $id = $operatorDTO->id;
        $name = $operatorDTO->firstName;
        $lastName = $operatorDTO->lastName;
        $phoneNumber = $operatorDTO->phoneNumber;
        $treatments = $operatorDTO->treatments;

        $operator = $this->entityManager->getRepository(Operator::class)->find($id);

        $operator->setFirstName($name);
        $operator->setLastName($lastName);
        $operator->setPhoneNumber($phoneNumber);


        $currentTreatments = $operator->getTreatments();

        foreach ($currentTreatments as $t) {
            if (!in_array($t, $treatments)) {
                $operator->removeTreatment($t);
            }
        }

        foreach ($treatments as $t) {
            $operator->addTreatment($t);
        }

        $this->entityManager->persist($operator);
        $this->entityManager->flush();

        return $operator;
    }

    /**
     * @param Operator $operator
     * @return void
     */
    public function delete(Operator $operator): void
    {
        $this->entityManager->remove($operator);
        $this->entityManager->flush();
    }

}
