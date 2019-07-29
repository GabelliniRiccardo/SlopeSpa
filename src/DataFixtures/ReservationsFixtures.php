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
            TreatmentsFixtures::class,
            SPAsFixtures::class,
        );
    }

    private function getReservationsData(): array
    {
        return
            [
                [
                    'start_time' => new \DateTimeImmutable('2019-03-02 17:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-03-02 18:00:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 6
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-07-26 15:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-07-26 16:30:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 10
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-02-15 11:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-02-15 12:00:00'),
                    'duration' => 3600,
                    'price' => 50,
                    'treatment_id' => 1,
                    'customer_id' => 4,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 8
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-20 09:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-20 10:00:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 5
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-02-15 16:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-02-15 17:00:00'),
                    'duration' => 3600,
                    'price' => 80,
                    'treatment_id' => 5,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 8
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-20 09:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-20 10:00:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 2
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-08-09 10:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-08-09 11:00:00'),
                    'duration' => 3600,
                    'price' => 50,
                    'treatment_id' => 1,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 4
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-07-26 12:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-07-26 14:00:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 10
                ],
            ];
    }
}
