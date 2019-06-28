<?php


namespace App\Command\Admin;


use App\Entity\SPA;
use App\Model\DTO\UserDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUser
{
    /**
     * @var UserDTO
     * @Assert\Valid
     */
    public $userDTO;

    public function __construct(SPA $spa)
    {
        $this->userDTO = new UserDTO();
        $this->userDTO->spa = $spa;
    }
}
