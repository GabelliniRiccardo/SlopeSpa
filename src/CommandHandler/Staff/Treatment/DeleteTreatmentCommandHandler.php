<?php


namespace App\CommandHandler\Staff\Treatment;


use App\Command\Staff\Treatment\DeleteTreatment;
use App\Service\DomainManager\TreatmentManager;

class DeleteTreatmentCommandHandler
{
    protected $treatmentManager;

    public function __construct(TreatmentManager $treatmentManager)
    {
        $this->treatmentManager = $treatmentManager;
    }

    public function handle(DeleteTreatment $command): void
    {
        $this->treatmentManager->delete($command->treatment);
    }
}
