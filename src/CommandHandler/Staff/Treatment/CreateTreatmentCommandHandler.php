<?php


namespace App\CommandHandler\Staff\Treatment;


use App\Command\Staff\Treatment\CreateTreatment;
use App\Service\DomainManager\TreatmentManager;

class CreateTreatmentCommandHandler
{
    protected $treatmentManager;

    public function __construct(TreatmentManager $treatmentManager)
    {
        $this->treatmentManager = $treatmentManager;
    }

    public function handle(CreateTreatment $command): void
    {
        $this->treatmentManager->create($command->treatmentDTO);
    }
}
