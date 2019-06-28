<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\DeleteSPA;
use App\Service\DomainManager\SpaManager;

class DeleteSPACommandHandler
{
    protected $spaManager;

    public function __construct(SpaManager $spaManager)
    {
        $this->spaManager = $spaManager;
    }

    public function handle(DeleteSPA $command): void
    {
        $this->spaManager->delete($command->spa);
    }
}
