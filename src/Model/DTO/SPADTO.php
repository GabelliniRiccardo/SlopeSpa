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
     * )
     * @var string
     */
    public $address;

    /**
     * @Assert\Length(min = 8, max = 20, )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="DTO.SPADTO.NumbersOnly")
     * @var string
     */
    public $phoneNumber;
}
