<?php


namespace App\Command\Staff\Customer;


use App\Entity\Customer;
use App\Model\DTO\CustomerDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditCustomer
{
    /**
     * @var $customerDTO
     * @Assert\Valid
     */
    public $customerDTO;

    public function __construct(Customer $customer)
    {
        $this->customerDTO = new CustomerDTO($customer->getSpa());
        $this->assignDATAToCustomerDTO($customer);
    }

    private function assignDATAToCustomerDTO(Customer $customer): void
    {
        $id = $customer->getId();
        $firstName = $customer->getFirstName();
        $lastName = $customer->getLastName();
        $address = $customer->getAddress();
        $birthday = $customer->getBirthday();
        $phoneNumber = $customer->getPhoneNumber();
        $spa = $customer->getSpa();

        $this->customerDTO->id = $id;
        $this->customerDTO->firstName = $firstName;
        $this->customerDTO->lastName = $lastName;
        $this->customerDTO->address = $address;
        $this->customerDTO->birthday = $birthday;
        $this->customerDTO->phoneNumber = $phoneNumber;
        $this->customerDTO->spa = $spa;
    }
}
