<?php


namespace App\CommandHandler\Staff\Operator;



use App\Command\Staff\Operator\CreateOperator;
use App\Service\DomainManager\OperatorManager;

class CreateOperatorCommandHandler
{
    protected $operatorManager;

    public function __construct(OperatorManager $operatorManager)
    {
        $this->operatorManager = $operatorManager;
    }

    public function handle(CreateOperator $command): void
    {
        $this->operatorManager->create($command->operatorDTO);
    }
}
