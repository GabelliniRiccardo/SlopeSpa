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
            [
                'name' => 'Massaggio Kembiki',
                'price' => 50,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [4, 6, 8],
                'spa_id' => 1
            ],
            [
                'name' => 'Massaggio Ayurvedico',
                'price' => 70,
                'duration' => 5400,
                'VAT' => 22,
                'operators_id' => [6, 10],
                'spa_id' => 1
            ],
            [
                'name' => 'Linfodrenaggio Gambe',
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
                'name' => 'Massaggio Californiano',
                'price' => 80,
                'duration' => 3600,
                'VAT' => 22,
                'operators_id' => [7, 8, 10],
                'spa_id' => 1
            ],
        ];
    }
}
