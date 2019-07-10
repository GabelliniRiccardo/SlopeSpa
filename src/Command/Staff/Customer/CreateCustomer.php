<?php


namespace App\Command\Staff\Customer;
use App\Entity\SPA;
use App\Model\DTO\CustomerDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCustomer
{
    /**
     * @var CustomerDTO
     * @Assert\Valid
     */
    public $customerDTO;

    public function __construct(SPA $spa)
    {
        $this->customerDTO = new CustomerDTO($spa);
    }
}
