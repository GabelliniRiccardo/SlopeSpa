<?php


namespace App\Model\DTO;


use App\Entity\SPA;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerDTO
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    public $firstName;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    public $lastName;

    /**
     * @var \DateTimeImmutable
     */
    public $birthday;

    /**
     * @Assert\Length(
     *      min = 3,
     *      max = 60,
     * )
     * @var string
     */
    public $address;

    /**
     * @Assert\Length(min = 8, max = 20, )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="DTO.CustomerDTO.NumbersOnly")
     * @var string
     */
    public $phoneNumber;

    /**
     * @var SPA
     */
    public $spa;

    /**
     * CustomerDTO constructor.
     * @param SPA $spa
     */
    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
