<?php


namespace App\Command\Admin;



use App\Entity\User;

class DeleteUser
{
    /**
     * @var User
     * @Assert\Valid
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
