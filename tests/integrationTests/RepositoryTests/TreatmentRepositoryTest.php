<?php

namespace App\Tests\integrationTests\RepositoryTests;


use App\Entity\Treatment;
use App\Tests\integrationTests\BaseIntegrationTest;

class TreatmentRepositoryTest extends BaseIntegrationTest
{
    private $treatmentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->treatmentRepository = $this->entityManager->getRepository(Treatment::class);
    }

    public function testFindAvailableTreatmentsUsingOperator()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $operatorId = 6;
        $startTime = new \DateTimeImmutable('2019-03-02 17:00:00');
        $endTime = new \DateTimeImmutable('2019-03-02 18:00:00');
        $treatments = $this->treatmentRepository->findAvailableTreatmentsUsingOperator($operatorId, $startTime, $endTime, null);
        $this->assertSame(sizeof($treatments), 2);
    }

    public function testGetNumberOfReservationPerTreatment()
    {
        $numberOfReservationsPerTreatment = $this->treatmentRepository->getNumberOfReservationPerTreatment();
        $values = (array_column($numberOfReservationsPerTreatment, 'numOfReservations'));
        $this->assertSame($values, [1, 2, 2, 1, 2]);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
