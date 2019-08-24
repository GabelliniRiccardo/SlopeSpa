<?php

namespace App\Tests\integrationTests\RepositoryTests;


use App\Entity\Operator;
use App\Tests\integrationTests\BaseIntegrationTest;

class OperatorRepositoryTest extends BaseIntegrationTest
{
    private $operatorRepository;

    public function setUp()
    {
        parent::setUp();
        $this->operatorRepository = $this->entityManager->getRepository(Operator::class);
    }

    public function testFindAvailableOperatorsUsingTreatment()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $treatmentId = 4;
        $startTime = new \DateTimeImmutable('2019-03-02 17:00:00');
        $endTime = new \DateTimeImmutable('2019-03-02 18:00:00');
        $operators = $this->operatorRepository->findAvailableOperatorsUsingTreatment($treatmentId, $startTime, $endTime, null);
        $this->assertSame(sizeof($operators), 3);
    }

    public function testGetNumberOfReservationPerOperator()
    {
        $numberOfReservationsPerOperator = $this->operatorRepository->getNumberOfReservationPerOperator();
        $values = (array_column($numberOfReservationsPerOperator, 'numOfReservations'));
        $this->assertSame($values,
            [
                0, 5, 2, 2, 2, 2, 0, 3, 0, 4, 1, 3, 2, 0, 1, 1, 3, 0, 2, 3, 0, 0, 4, 0, 0,
            ]
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
