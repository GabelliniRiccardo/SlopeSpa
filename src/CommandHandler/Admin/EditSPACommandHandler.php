<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\EditSPA;
use App\Service\DomainManager\SpaManager;

class EditSPACommandHandler
{
    protected $spaManager;

    public function __construct(SpaManager $spaManager)
    {
        $this->spaManager = $spaManager;
    }

    public function handle(EditSPA $command): void
    {
        $this->spaManager->update($command->spaDTO);
    }
}
