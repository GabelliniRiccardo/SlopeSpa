<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\CreateUser;
use App\Service\DomainManager\UserManager;

class CreateUserCommandHandler
{
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(CreateUser $command): void
    {
        $this->userManager->create($command->userDTO);
    }
}
