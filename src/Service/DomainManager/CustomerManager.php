<?php


namespace App\Service\DomainManager;


use App\Entity\Customer;
use App\Model\DTO\CustomerDTO;
use Doctrine\ORM\EntityManagerInterface;

class CustomerManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param CustomerDTO $customerDTO
     * @return Customer
     */
    public function create(CustomerDTO $customerDTO): Customer
    {

        $fistName = $customerDTO->firstName;
        $lastName = $customerDTO->lastName;
        $address = $customerDTO->address;
        $birthday = $customerDTO->birthday;
        $phoneNumber = $customerDTO->phoneNumber;
        $spa = $customerDTO->spa;

        $customer = new Customer($fistName, $lastName, $spa);

        if (!!$address) {
            $customer->setAddress($address);
        }

        if (!!$birthday) {
            $customer->setBirthday($birthday);
        }

        if (!!$phoneNumber) {
            $customer->setPhoneNumber($phoneNumber);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    /**
     * @param CustomerDTO $customerDTO
     * @return Customer
     */
    public function update(CustomerDTO $customerDTO): Customer
    {
        $id = $customerDTO->id;
        $name = $customerDTO->firstName;
        $lastName = $customerDTO->lastName;
        $address = $customerDTO->address;
        $birthday = $customerDTO->birthday;
        $phoneNumber = $customerDTO->phoneNumber;
        $spa = $customerDTO->spa;

        $customer = $this->entityManager->getRepository(Customer::class)->find($id);

        $customer->setFirstName($name);
        $customer->setLastName($lastName);
        $customer->setAddress($address);
        $customer->setBirthday($birthday);
        $customer->setPhoneNumber($phoneNumber);
        $customer->setSpa($spa);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return void
     */
    public function delete(Customer $customer): void
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}
