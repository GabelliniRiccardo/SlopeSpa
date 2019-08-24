<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\TreatmentCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TreatmentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getTreatmentsData() as $fields) {
            TreatmentCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            OperatorsFixtures::class,
            SPAsFixtures::class,
        );
    }

    private function getTreatmentsData(): array
    {
        return [
            // Treatments of SPA with ID 1

            [
                'name' => 'Kembiki Massage',
                'price' => 50,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [4, 6, 8],
                'spa_id' => 1
            ],
            [
                'name' => 'Ayurvedic Massaggio',
                'price' => 70,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [6, 10],
                'spa_id' => 1
            ],
            [
                'name' => 'Leg Lymph Drainage',
                'price' => 30,
                'duration' => 1800,
                'VAT' => 22,
                'operators_id' => [2, 5],
                'spa_id' => 1
            ],
            [
                'name' => 'Hot Stone Massage',
                'price' => 60,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [3, 6, 9],
                'spa_id' => 1
            ],
            [
                'name' => 'Californian Massage',
                'price' => 80,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [7, 8, 10],
                'spa_id' => 1
            ],
            [
                'name' => 'Hawaiian Lomi-Lomi Massage',
                'price' => 45,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [1, 11],
                'spa_id' => 1
            ],
            [
                'name' => 'Osteopatic Treatment',
                'price' => 75,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [13, 14,],
                'spa_id' => 1
            ],
            [
                'name' => 'Total Body Massage',
                'price' => 65,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [1, 12],
                'spa_id' => 1
            ],
            [
                'name' => 'Anti-stress Massage',
                'price' => 90,
                'duration' => 7200,
                'VAT' => 22,
                'operators_id' => [7, 12, 13],
                'spa_id' => 1
            ],
            [
                'name' => 'Aromatherapy Massage',
                'price' => 40,
                'duration' => 1800,
                'VAT' => 22,
                'operators_id' => [11, 15],
                'spa_id' => 1
            ],


            // Treatments of SPA with ID 2

            [
                'name' => 'Massaggio con cera',
                'price' => 40,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [17, 24, 18],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio agli oli essenziali',
                'price' => 60,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [20],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio anti-cellulite',
                'price' => 50,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [16, 25],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio viso anti-rughe',
                'price' => 20,
                'duration' => 1800,
                'VAT' => 22,
                'operators_id' => [18, 21, 22],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio rilassamento muscolare',
                'price' => 30,
                'duration' => 1800,
                'VAT' => 22,
                'operators_id' => [16, 23],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio cranio sacrale',
                'price' => 70,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [21],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio alle foglie di The',
                'price' => 65,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [19, 20],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio cinese',
                'price' => 80,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [25],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio giapponese',
                'price' => 90,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [19, 22],
                'spa_id' => 2
            ],
            [
                'name' => 'Massaggio thailandese',
                'price' => 100,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [18, 23],
                'spa_id' => 2
            ],
        ];
    }
}
