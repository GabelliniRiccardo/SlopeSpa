<?php

namespace App\Tests\integrationTests\ManagerTests;

use App\Entity\Customer;
use App\Entity\Operator;
use App\Entity\Reservation;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Model\DTO\ReservationDTO;
use App\Service\DomainManager\ReservationManager;
use App\Tests\integrationTests\BaseIntegrationTest;

class ReservationManagerTest extends BaseIntegrationTest
{
    private $reservationManager;

    public function setUp()
    {
        parent::setUp();
        $this->reservationManager = self::$container->get(ReservationManager::class);
    }

    public function testCreate()
    {
        $spa = $this->entityManager->getRepository(SPA::class)->find(1);
        $startTime = new \DateTimeImmutable('2019-01-01 14:00:00');
        $endTime = new \DateTimeImmutable('2019-01-01 15:00:00');
        $customer = $this->entityManager->getRepository(Customer::class)->find(1);
        $treatment = $this->entityManager->getRepository(Treatment::class)->find(1);
        $operator = $this->entityManager->getRepository(Operator::class)->find(4);

        $reservationDTO = new ReservationDTO($spa);
        $reservationDTO->customer = $customer;
        $reservationDTO->treatment = $treatment;
        $reservationDTO->money = $treatment->getMoney();
        $reservationDTO->vat = $treatment->getVat();
        $reservationDTO->operator = $operator;
        $reservationDTO->start_time = $startTime;
        $reservationDTO->end_time = $endTime;

        $reservation = $this->reservationManager->create($reservationDTO);

        $this->assertSame($reservation->getCustomer(), $customer);
        $this->assertSame($reservation->getTreatment(), $treatment);
        $this->assertSame($reservation->getMoney(), $treatment->getMoney());
        $this->assertSame($reservation->getVat(), $treatment->getVat());
        $this->assertSame($reservation->getOperator(), $operator);
        $this->assertSame($reservation->getStartTime(), $startTime);
        $this->assertSame($reservation->getEndTime(), $endTime);
    }

    public function testUpdate()
    {
        $id = 1;
        $newSpa = $this->entityManager->getRepository(SPA::class)->find(1);
        $newStartTime = new \DateTimeImmutable('2019-01-01 14:00:00');
        $newEndTime = new \DateTimeImmutable('2019-01-01 15:00:00');
        $newCustomer = $this->entityManager->getRepository(Customer::class)->find(1);
        $newTreatment = $this->entityManager->getRepository(Treatment::class)->find(1);
        $newOperator = $this->entityManager->getRepository(Operator::class)->find(4);

        $reservationDTO = new ReservationDTO($newSpa);
        $reservationDTO->id = $id;
        $reservationDTO->customer = $newCustomer;
        $reservationDTO->treatment = $newTreatment;
        $reservationDTO->duration = $newTreatment->getDuration();
        $reservationDTO->money = $newTreatment->getMoney();
        $reservationDTO->vat = $newTreatment->getVat();
        $reservationDTO->operator = $newOperator;
        $reservationDTO->start_time = $newStartTime;
        $reservationDTO->end_time = $newEndTime;

        $reservation = $this->reservationManager->update($reservationDTO);

        $this->assertSame($reservation->getCustomer(), $newCustomer);
        $this->assertSame($reservation->getTreatment(), $newTreatment);
        $this->assertSame($reservation->getMoney(), $newTreatment->getMoney());
        $this->assertSame($reservation->getVat(), $newTreatment->getVat());
        $this->assertSame($reservation->getOperator(), $newOperator);
        $this->assertSame($reservation->getStartTime(), $newStartTime);
        $this->assertSame($reservation->getEndTime(), $newEndTime);
    }

    public function testDelete()
    {
        $this->expectException('Doctrine\ORM\NoResultException');
        $reservation = $this->entityManager->getRepository(Reservation::class)->find(1);
        $this->reservationManager->delete($reservation);
        $this->entityManager->getRepository(Reservation::class)->find(1);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
