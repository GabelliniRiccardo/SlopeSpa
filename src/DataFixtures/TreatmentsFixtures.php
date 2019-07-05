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
            RoomsFixtures::class,
            SPAsFixtures::class,
        );
    }

    private function getTreatmentsData(): array
    {
        return [
            [
                'name' => 'Treatment 1',
                'price' => 20.5,
                'duration' => 1800,
                'VAT' => 22,
                'operator_id' => 1,
                'rooms_ids' => [1,2,3],
                'spa_id' => 1
            ],
            [
                'name' => 'Treatment 2',
                'price' => 50.5,
                'duration' => 3600,
                'VAT' => 22,
                'operator_id' => 2,
                'rooms_ids' => [4,5,6],
                'spa_id' => 2
            ],
            [
                'name' => 'Treatment 3',
                'price' => 100,
                'duration' => 3600,
                'VAT' => 22,
                'operator_id' => 3,
                'rooms_ids' => [7,8,9],
                'spa_id' => 1
            ],
            [
                'name' => 'Treatment 4',
                'price' => 200,
                'duration' => 2700,
                'VAT' => 22,
                'operator_id' => 3,
                'rooms_ids' => [1,2,3],
                'spa_id' => 1
            ],
            [
                'name' => 'Treatment 5',
                'price' => 50,
                'duration' => 5400,
                'VAT' => 22,
                'operator_id' => 3,
                'rooms_ids' => [4,5,6],
                'spa_id' => 1
            ],
            [
                'name' => 'Treatment 6',
                'price' => 30,
                'duration' => 7200,
                'VAT' => 22,
                'operator_id' => 1,
                'rooms_ids' => [7,8,9],
                'spa_id' => 1
            ],
        ];
    }
}
