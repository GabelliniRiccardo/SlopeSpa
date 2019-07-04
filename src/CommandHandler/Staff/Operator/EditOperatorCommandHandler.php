<?php


namespace App\CommandHandler\Staff\Operator;


use App\Command\Staff\Operator\EditOperator;
use App\Service\DomainManager\OperatorManager;

class EditOperatorCommandHandler
{
    protected $operatorManager;

    public function __construct(OperatorManager $operatorManager)
    {
        $this->operatorManager = $operatorManager;
    }

    public function handle(EditOperator $command): void
    {
        $this->operatorManager->update($command->operatorDTO);
    }
}
