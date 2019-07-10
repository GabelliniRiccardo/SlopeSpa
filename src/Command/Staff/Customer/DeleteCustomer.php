<?php


namespace App\Command\Staff\Customer;
use App\Entity\Customer;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteCustomer
{
    /**
     * @var Customer
     * @Assert\Valid
     */
    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
