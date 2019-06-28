<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\DeleteUser;
use App\Service\DomainManager\UserManager;

class DeleteUserCommandHandler
{
    protected $staffManager;

    public function __construct(UserManager $staffManager)
    {
        $this->staffManager = $staffManager;
    }

    public function handle(DeleteUser $command): void
    {
        $this->staffManager->delete($command->user);
    }
}
