<?php

namespace App\Tests\integrationTests\RepositoryTests;


use App\Entity\Reservation;
use App\Tests\integrationTests\BaseIntegrationTest;

class ReservationRepositoryTest extends BaseIntegrationTest
{
    private $reservationRepository;

    public function setUp()
    {
        parent::setUp();
        $this->reservationRepository = $this->entityManager->getRepository(Reservation::class);
    }

    public function testGetReservationsWithouthTenancy()
    {
        $this->multitenantService->setMultitenant(false);
        $reservations = $this->reservationRepository->getReservations();
        $this->assertSame(sizeof($reservations), 40);
    }

    public function testGetReservationsWithTenancy()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $reservations = $this->reservationRepository->getReservations();
        $this->assertSame(sizeof($reservations), 39);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
