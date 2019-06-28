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
     *     message="Name cannot contain a number"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The User's name must be at least {{ limit }} characters long",
     *      maxMessage = "The User's name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     match=true,
     *     message="Last name cannot contain a number"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The User's last name must be at least {{ limit }} characters long",
     *      maxMessage = "The User's last name cannot be longer than {{ limit }} characters"
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
     *      minMessage = "Password must be at least {{ limit }} characters long",
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
