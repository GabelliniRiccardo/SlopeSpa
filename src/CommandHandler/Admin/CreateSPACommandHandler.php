<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\CreateSPA;
use App\Service\DomainManager\SpaManager;


class CreateSPACommandHandler
{
    protected $spaManager;

    public function __construct(SpaManager $spaManager)
    {
        $this->spaManager = $spaManager;
    }

    public function handle(CreateSPA $command): void
    {
        $this->spaManager->create($command->spaDTO);
    }
}
