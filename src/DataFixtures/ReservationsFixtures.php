<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\ReservationCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReservationsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getReservationsData() as $fields) {
            ReservationCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            CustomersFixtures::class,
            RoomsFixtures::class,
            TreatmentsFixtures::class,
            SPAsFixtures::class,
        );
    }

    private function getReservationsData(): array
    {
        return
            [
                [
                    'start_time' => new \DateTimeImmutable('2019-01-03 14:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-01-03 15:30:00'),
                    'duration' => 60,
                    'price' => 30,
                    'treatment_id' => 1,
                    'room_id' => 1,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-01-02 8:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-01-02 9:30:00'),
                    'duration' => 30,
                    'price' => 30,
                    'treatment_id' => 1,
                    'room_id' => 2,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-01-01 17:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-01-01 18:00:00'),
                    'duration' => 30,
                    'price' => 30,
                    'treatment_id' => 1,
                    'room_id' => 3,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1
                ],
            ];
    }
}
