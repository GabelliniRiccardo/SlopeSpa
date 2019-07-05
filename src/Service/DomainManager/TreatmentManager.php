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
        $money = $treatmentDTO->money;

        $money = new Money($money->getValue(), $money->getCurrency());
        $duration = $treatmentDTO->duration;
        $vat = $treatmentDTO->vat;
        $spa = $treatmentDTO->spa;

        $treatment = new Treatment($name, $money, $duration, $vat, $spa);

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return $treatment;
    }

    /**
     * @param TreatmentDTO $treatmentDTO
     * @return Treatment
     */
    public function update(TreatmentDTO $treatmentDTO): Treatment
    {
        $id = $treatmentDTO->id;
        $name = $treatmentDTO->name;
        $money = $treatmentDTO->money;
        $duration = $treatmentDTO->duration;
        $vat = $treatmentDTO->vat;
        $spa = $treatmentDTO->spa;

        $treatment = $this->entityManager->getRepository(Treatment::class)->find($id);
        $this->entityManager->refresh($treatment);

        $treatment->setName($name);
        $treatment->setDuration($duration);
        $treatment->setVat($vat);
        $treatment->setSpa($spa);
        $treatment->setMoney($money);

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return $treatment;
    }

    /**
     * @param Treatment $treatment
     * @return void
     */
    public function delete(Treatment $treatment): void
    {
        $this->entityManager->remove($treatment);
        $this->entityManager->flush();
    }
}
