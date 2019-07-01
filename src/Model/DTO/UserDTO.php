<?php


namespace App\Model\DTO;


use App\Entity\SPA;
use Symfony\Component\Validator\Constraints as Assert;

class UserDTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     match=true,
     *     message="DTO.UserDTO.Name.LettersOnly"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     match=true,
     *     message="DTO.UserDTO.LastName.LettersOnly"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    public $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     * )
     * @var string
     */
    public $password;

    /**
     * @var array
     */
    public $roles = [];

    /**
     * @var SPA
     */
    public $spa;
}
