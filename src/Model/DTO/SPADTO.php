<?php


namespace App\Model\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SPADTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The SPA's name must be at least {{ limit }} characters long",
     *      maxMessage = "The SPA's name cannot be longer than {{ limit }} characters"
     * )
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    public $email;

    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The SPA's address must be at least {{ limit }} characters long",
     *      maxMessage = "The SPA's address cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $address;

    /**
     * @Assert\Length(min = 8, max = 20, )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="please insert number_only")
     * @var string
     */
    public $phoneNumber;
}
