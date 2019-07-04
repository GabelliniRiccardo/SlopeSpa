<?php


namespace App\Command\Staff\Treatment;


use App\Entity\SPA;
use App\Model\DTO\TreatmentDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTreatment
{
    /**
     * @var TreatmentDTO
     * @Assert\Valid
     */
    public $treatmentDTO;

    public function __construct(SPA $spa)
    {
        $this->treatmentDTO = new TreatmentDTO($spa);
    }
}
