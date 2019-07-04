<?php


namespace App\Model\DTO;


use App\Entity\SPA;
use App\Entity\Treatment;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class OperatorDTO
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
     * @Assert\Length(min = 8, max = 20, )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="DTO.OperatorDTO.NumbersOnly")
     * @var string
     */
    public $phoneNumber;

    /**
     * @var SPA
     */
    public $spa;

    /**
     *  @var Collection|Treatment[]
     */
    public $treatments;

    /**
     * OperatorDTO constructor.
     * @param SPA $spa
     */
    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
