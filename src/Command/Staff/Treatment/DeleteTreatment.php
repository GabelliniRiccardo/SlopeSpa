<?php


namespace App\Command\Staff\Treatment;


use App\Entity\Treatment;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteTreatment
{
    /**
     * @var Treatment
     * @Assert\Valid
     */
    public $treatment;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
    }
}
