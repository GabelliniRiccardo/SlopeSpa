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
                //BEGIN OF RESERVATIONS FOR SPA WITH ID 1

                // Reservations of OPERATOR with ID 1

                // This is a past reservation (2019-01-01) for functional tests
                [
                    'start_time' => new \DateTimeImmutable('2019-01-01 09:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-01-01 10:15:00'),
                    'duration' => 3600,
                    'price' => 45,
                    'treatment_id' => 6,
                    'customer_id' => 10,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-03 09:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-03  10:15:00'),
                    'duration' => 3600,
                    'price' => 45,
                    'treatment_id' => 6,
                    'customer_id' => 10,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-07 15:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-07  16:30:00'),
                    'duration' => 3600,
                    'price' => 65,
                    'treatment_id' => 8,
                    'customer_id' => 6,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-17 18:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-17  19:30:00'),
                    'duration' => 3600,
                    'price' => 45,
                    'treatment_id' => 6,
                    'customer_id' => 7,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 1
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-24 08:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-24  09:00:00'),
                    'duration' => 3600,
                    'price' => 65,
                    'treatment_id' => 8,
                    'customer_id' => 9,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 1
                ],

                // Reservations of OPERATOR with ID 2

                [
                    'start_time' => new \DateTimeImmutable('2019-10-1 08:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-1  08:30:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 2
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-11 16:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-11  17:00:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 4,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 2
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-15 18:45:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-15  19:15:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 4,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 2
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-22 12:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-22  13:00:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 8,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 2
                ],

                // Reservations of OPERATOR with ID 3

                [
                    'start_time' => new \DateTimeImmutable('2019-10-02 17:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-02  18:00:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 6,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 3
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-08 09:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-08  10:30:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 8,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 3
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-25 11:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-25  12:00:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 3
                ],

                // Reservations of OPERATOR with ID 4

                [
                    'start_time' => new \DateTimeImmutable('2019-10-04 12:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-04  13:00:00'),
                    'duration' => 3600,
                    'price' => 50,
                    'treatment_id' => 1,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 4
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-09 08:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-09  09:30:00'),
                    'duration' => 3600,
                    'price' => 50,
                    'treatment_id' => 1,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 4
                ],

                // Reservations of OPERATOR with ID 5

                [
                    'start_time' => new \DateTimeImmutable('2019-10-10 17:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-10  18:00:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 5
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-16 19:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-16  19:30:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 5
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-23 16:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-23  16:45:00'),
                    'duration' => 1800,
                    'price' => 30,
                    'treatment_id' => 3,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 5
                ],

                // Reservations of OPERATOR with ID 6

                [
                    'start_time' => new \DateTimeImmutable('2019-10-14 16:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-14  17:30:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 6
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-18 15:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-18  16:30:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 6,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 6
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-21 18:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-21  19:00:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 4,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 6
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-24 9:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-24  10:30:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 7,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 6
                ],

                // Reservations of OPERATOR with ID 7

                [
                    'start_time' => new \DateTimeImmutable('2019-10-03 16:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-03  18:00:00'),
                    'duration' => 7200,
                    'price' => 90,
                    'treatment_id' => 9,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 7
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-09 11:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-09  12:00:00'),
                    'duration' => 3600,
                    'price' => 80,
                    'treatment_id' => 5,
                    'customer_id' => 8,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 7
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-18 10:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-18  12:30:00'),
                    'duration' => 7200,
                    'price' => 90,
                    'treatment_id' => 9,
                    'customer_id' => 9,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 7
                ],

                // Reservations of OPERATOR with ID 8

                [
                    'start_time' => new \DateTimeImmutable('2019-10-01 12:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-01  13:00:00'),
                    'duration' => 3600,
                    'price' => 80,
                    'treatment_id' => 5,
                    'customer_id' => 10,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 8
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-08 14:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-08  15:00:00'),
                    'duration' => 3600,
                    'price' => 80,
                    'treatment_id' => 5,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 8
                ],

                // Reservations of OPERATOR with ID 9

                [
                    'start_time' => new \DateTimeImmutable('2019-10-25 10:45:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-25  11:45:00'),
                    'duration' => 3600,
                    'price' => 60,
                    'treatment_id' => 4,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 9
                ],

                // Reservations of OPERATOR with ID 10

                [
                    'start_time' => new \DateTimeImmutable('2019-10-10 17:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-10  18:30:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 7,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 10
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-23 16:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-23  18:00:00'),
                    'duration' => 5400,
                    'price' => 70,
                    'treatment_id' => 2,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 10
                ],

                // Reservations of OPERATOR with ID 11

                [
                    'start_time' => new \DateTimeImmutable('2019-10-02 14:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-02  15:00:00'),
                    'duration' => 3600,
                    'price' => 45,
                    'treatment_id' => 6,
                    'customer_id' => 9,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 11
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-07 08:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-07  09:00:00'),
                    'duration' => 1800,
                    'price' => 40,
                    'treatment_id' => 10,
                    'customer_id' => 10,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 11
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-22 10:00:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-22  10:30:00'),
                    'duration' => 1800,
                    'price' => 40,
                    'treatment_id' => 10,
                    'customer_id' => 1,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 11
                ],

                // Reservations of OPERATOR with ID 12

                [
                    'start_time' => new \DateTimeImmutable('2019-10-04 11:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-04  12:15:00'),
                    'duration' => 3600,
                    'price' => 65,
                    'treatment_id' => 8,
                    'customer_id' => 10,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 12
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-11 16:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-11  17:15:00'),
                    'duration' => 3600,
                    'price' => 65,
                    'treatment_id' => 8,
                    'customer_id' => 6,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 12
                ],

                // Reservations of OPERATOR with ID 13

                [
                    'start_time' => new \DateTimeImmutable('2019-10-24 09:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-24  11:00:00'),
                    'duration' => 5400,
                    'price' => 75,
                    'treatment_id' => 7,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 13
                ],

                // Reservations of OPERATOR with ID 14

                [
                    'start_time' => new \DateTimeImmutable('2019-10-14 18:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-14  20:00:00'),
                    'duration' => 5400,
                    'price' => 75,
                    'treatment_id' => 7,
                    'customer_id' => 9,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 14
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-21 14:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-21  16:00:00'),
                    'duration' => 5400,
                    'price' => 75,
                    'treatment_id' => 7,
                    'customer_id' => 5,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 14
                ],

                // Reservations of OPERATOR with ID 15

                [
                    'start_time' => new \DateTimeImmutable('2019-10-04 15:30:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-04  16:00:00'),
                    'duration' => 1800,
                    'price' => 40,
                    'treatment_id' => 10,
                    'customer_id' => 3,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 15
                ],
                [
                    'start_time' => new \DateTimeImmutable('2019-10-18 11:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-18  11:45:00'),
                    'duration' => 1800,
                    'price' => 40,
                    'treatment_id' => 10,
                    'customer_id' => 2,
                    'VAT' => 22.0,
                    'spa_id' => 1,
                    'operator_id' => 15
                ],

                //BEGIN OF RESERVATIONS FOR SPA WITH ID 2

                // Reservations of OPERATOR with ID 16

                [
                    'start_time' => new \DateTimeImmutable('2019-10-25 11:15:00'),
                    'end_time' => new \DateTimeImmutable('2019-10-25  12:15:00'),
                    'duration' => 3600,
                    'price' => 40,
                    'treatment_id' => 11,
                    'customer_id' => 12,
                    'VAT' => 22.0,
                    'spa_id' => 2,
                    'operator_id' => 18
                ],
            ];
    }
}
