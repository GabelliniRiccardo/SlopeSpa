<?php

namespace App\Tests\integrationTests\RepositoryTests;


use App\Entity\Customer;
use App\Tests\integrationTests\BaseIntegrationTest;

class CustomerRepositoryTest extends BaseIntegrationTest
{
    private $customerRepository;

    public function setUp()
    {
        parent::setUp();
        $this->customerRepository = $this->entityManager->getRepository(Customer::class);
    }

    public function testFindAll()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $customers = $this->customerRepository->findAll();
        $this->assertSame(sizeof($customers), 10);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
