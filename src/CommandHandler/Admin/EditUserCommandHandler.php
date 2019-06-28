<?php


namespace App\CommandHandler\Admin;


use App\Command\Admin\EditUser;
use App\Service\DomainManager\UserManager;

class EditUserCommandHandler
{
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(EditUser $command): void
    {
        $this->userManager->update($command->userDTO);
    }
}
