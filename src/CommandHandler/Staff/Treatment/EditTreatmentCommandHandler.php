<?php


namespace App\CommandHandler\Staff\Treatment;


use App\Command\Staff\Treatment\EditTreatment;
use App\Service\DomainManager\TreatmentManager;

class EditTreatmentCommandHandler
{
    protected $treatmentManager;

    public function __construct(TreatmentManager $treatmentManager)
    {
        $this->treatmentManager = $treatmentManager;
    }

    public function handle(EditTreatment $command): void
    {
        $this->treatmentManager->update($command->treatmentDTO);
    }
}
