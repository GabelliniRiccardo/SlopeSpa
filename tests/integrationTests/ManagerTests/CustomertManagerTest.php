<?php

namespace App\Tests\integrationTests\ManagerTests;

use App\Entity\Customer;
use App\Entity\SPA;
use App\Model\DTO\CustomerDTO;
use App\Service\DomainManager\CustomerManager;
use App\Tests\integrationTests\BaseIntegrationTest;

class CustomertManagerTest extends BaseIntegrationTest
{
    private $customerManager;

    public function setUp()
    {
        parent::setUp();
        $this->customerManager = self::$container->get(CustomerManager::class);
    }

    public function testCreate()
    {
        $firstName = 'test create first name';
        $lastNAme = 'test create last name';
        $address = 'test create';
        $birthday = new \DateTimeImmutable('1990-01-01');
        $phoneNumber = '1111111111';

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);
        $customerDTO = new CustomerDTO($spa);
        $customerDTO->firstName = $firstName;
        $customerDTO->lastName = $lastNAme;
        $customerDTO->address = $address;
        $customerDTO->birthday = $birthday;
        $customerDTO->phoneNumber = $phoneNumber;

        $customer = $this->customerManager->create($customerDTO);

        $this->assertSame($customer->getFirstName(), $firstName);
        $this->assertSame($customer->getLastName(), $lastNAme);
        $this->assertSame($customer->getAddress(), $address);
        $this->assertSame($customer->getBirthday(), $birthday);
        $this->assertSame($customer->getPhoneNumber(), $phoneNumber);
    }

    public function testUpdate()
    {
        $id = 1;
        $newFirstName = 'test update first name';
        $newLastNAme = 'test update last name';
        $newAddress = 'test update';
        $newBirthday = $birthday = new \DateTimeImmutable('1980-01-01');
        $newPhoneNumber = '2222222222';

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);

        $customerDTO = new CustomerDTO($spa);
        $customerDTO->id = $id;
        $customerDTO->firstName = $newFirstName;
        $customerDTO->lastName = $newLastNAme;
        $customerDTO->address = $newAddress;
        $customerDTO->birthday = $newBirthday;
        $customerDTO->phoneNumber = $newPhoneNumber;

        $customer = $this->customerManager->update($customerDTO);

        $this->assertSame($customer->getFirstName(), $newFirstName);
        $this->assertSame($customer->getLastName(), $newLastNAme);
        $this->assertSame($customer->getAddress(), $newAddress);
        $this->assertSame($customer->getBirthday(), $newBirthday);
        $this->assertSame($customer->getPhoneNumber(), $newPhoneNumber);
    }

    public function testDelete()
    {
        $this->expectException('Doctrine\ORM\NoResultException');
        $customer = $this->entityManager->getRepository(Customer::class)->find(1);
        $this->customerManager->delete($customer);
        $this->entityManager->getRepository(Customer::class)->find(1);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
