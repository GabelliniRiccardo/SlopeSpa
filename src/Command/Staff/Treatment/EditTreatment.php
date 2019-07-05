<?php


namespace App\Command\Staff\Treatment;


use App\Entity\Treatment;
use App\Model\DTO\TreatmentDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditTreatment
{
    /**
     * @var TreatmentDTO
     * @Assert\Valid
     */
    public $treatmentDTO;

    public function __construct(Treatment $treatment)
    {
        $this->treatmentDTO = new TreatmentDTO($treatment->getSpa());
        $this->assignDATAToTreatmentDTO($treatment);
    }

    private function assignDATAToTreatmentDTO(Treatment $treatment): void
    {
        $id = $treatment->getId();
        $name = $treatment->getName();
        $money = $treatment->getMoney();
        $duration = $treatment->getDuration();
        $vat = $treatment->getVat();
        $spa = $treatment->getSpa();

        $this->treatmentDTO->id = $id;
        $this->treatmentDTO->name = $name;
        $this->treatmentDTO->money = $money;
        $this->treatmentDTO->duration = $duration;
        $this->treatmentDTO->vat = $vat;
        $this->treatmentDTO->spa = $spa;
    }
}
