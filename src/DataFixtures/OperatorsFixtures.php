<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\OperatorCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OperatorsFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        foreach ($this->getOperatorsData() as $fields) {
            OperatorCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SPAsFixtures::class,
        );
    }

    private function getOperatorsData(): array
    {
        return [
            [
                'spa_id' => 1,
                'first_name' => 'Operator 1 name',
                'last_name' => 'Operator 1 last name',
                'phone_number' => '1111111111'
            ],
            [
                'spa_id' => 2,
                'first_name' => 'Operator 2 name',
                'last_name' => 'Operator 2 last name',
                'phone_number' => '2222222222'
            ],
            [
                'spa_id' => 1,
                'first_name' => 'Operator 3 name',
                'last_name' => 'Operator 3 last name',
                'phone_number' => '3333333333'
            ]
        ];
    }
}
