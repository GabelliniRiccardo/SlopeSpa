<?php


namespace App\Service\DomainManager;


use App\Entity\Treatment;
use App\Model\DTO\TreatmentDTO;
use App\Objects\Money;
use Doctrine\ORM\EntityManagerInterface;

class TreatmentManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param TreatmentDTO $treatmentDTO
     * @return Treatment
     */
    public function create(TreatmentDTO $treatmentDTO): Treatment
    {
        $name = $treatmentDTO->name;
        $price = $treatmentDTO->money;
        $money = new Money($price);
        $duration = $treatmentDTO->duration;
        $vat = $treatmentDTO->vat;
        $spa = $treatmentDTO->spa;

        $treatment = new Treatment($name, $money, $duration, $vat, $spa);

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return $treatment;
    }
}
