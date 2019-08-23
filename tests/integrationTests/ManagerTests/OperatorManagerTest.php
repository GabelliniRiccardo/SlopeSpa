<?php

namespace App\Tests\integrationTests\ManagerTests;


use App\Entity\Operator;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Model\DTO\OperatorDTO;
use App\Service\DomainManager\OperatorManager;
use App\Tests\integrationTests\BaseIntegrationTest;

class OperatorManagerTest extends BaseIntegrationTest
{
    private $operatorManager;

    public function setUp()
    {
        parent::setUp();
        $this->operatorManager = self::$container->get(OperatorManager::class);
    }

    public function testCreate()
    {
        $firstName = 'Operator create first name';
        $lastName = 'Operator create last name';
        $phoneNumber = '1111111111';
        $treatments = [];

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);

        $operatorDTO = new OperatorDTO($spa);
        $operatorDTO->firstName = $firstName;
        $operatorDTO->lastName = $lastName;
        $operatorDTO->phoneNumber = $phoneNumber;
        $operatorDTO->treatments = $treatments;

        $operator = $this->operatorManager->create($operatorDTO);

        $this->assertSame($operator->getFirstName(), $firstName);
        $this->assertSame($operator->getLastName(), $lastName);
        $this->assertSame($operator->getPhoneNumber(), $phoneNumber);
        $this->assertSame(sizeof($operator->getTreatments()), 0);
    }

    public function testUpdate()
    {
        $id = 1;
        $newFirstName = 'Operator create first name';
        $newLastName = 'Operator create last name';
        $newPhoneNumber = '1111111111';
        $newTreatments =
            [
                $this->entityManager->getRepository(Treatment::class)->find(1),
            ];

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);

        $operatorDTO = new OperatorDTO($spa);
        $operatorDTO->id = $id;
        $operatorDTO->firstName = $newFirstName;
        $operatorDTO->lastName = $newLastName;
        $operatorDTO->phoneNumber = $newPhoneNumber;
        $operatorDTO->treatments = $newTreatments;

        $operator = $this->operatorManager->create($operatorDTO);

        $this->assertSame($operator->getFirstName(), $newFirstName);
        $this->assertSame($operator->getLastName(), $newLastName);
        $this->assertSame($operator->getPhoneNumber(), $newPhoneNumber);
        $this->assertSame(sizeof($operator->getTreatments()), 1);
    }

    public function testDelete()
    {
        $this->expectException('Doctrine\ORM\NoResultException');
        $operator = $this->entityManager->getRepository(Operator::class)->find(1);
        $this->operatorManager->delete($operator);
        $this->entityManager->getRepository(Operator::class)->find(1);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
