<?php


namespace App\CommandHandler\Staff\Operator;


use App\Command\Staff\Operator\DeleteOperator;
use App\Service\DomainManager\OperatorManager;

class DeleteOperatorCommandHandler
{
    protected $operatorManager;

    public function __construct(OperatorManager $operatorManager)
    {
        $this->operatorManager = $operatorManager;
    }

    public function handle(DeleteOperator $command): void
    {
        $this->operatorManager->delete($command->operator);
    }
}
