<?php


namespace App\Command\Admin;


use App\Entity\User;
use App\Model\DTO\UserDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditUser
{
    /**
     * @var UserDTO
     * @Assert\Valid
     */
    public $userDTO;

    public function __construct(User $user)
    {
        $this->userDTO = new UserDTO();
        $this->assignDATAToUserDTO($user);
    }

    private function assignDATAToUserDTO(User $user): void
    {
        $id = $user->getId();
        $name = $user->getName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $roles = $user->getRoles();
        $spa = $user->getSpa();

        $this->userDTO->id = $id;
        $this->userDTO->name = $name;
        $this->userDTO->lastName = $lastName;
        $this->userDTO->email = $email;
        $this->userDTO->password = $password;
        $this->userDTO->roles = $roles;
        $this->userDTO->spa = $spa;
    }
}
