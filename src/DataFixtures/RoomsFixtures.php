<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\RoomCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RoomsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->loadRoomsData() as $fields) {
            RoomCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            SPAsFixtures::class,
        );
    }

    private function loadRoomsData(): array
    {
        return [
            [
                'name' => 'Room 1',
                'spa_id' => 1
            ],
            [
                'name' => 'Room 2',
                'spa_id' => 1
            ],
            [
                'name' => 'Room 3',
                'spa_id' => 1
            ],
            [
                'name' => 'Room 4',
                'spa_id' => 1
            ],
            [
                'name' => 'Room 5',
                'spa_id' => 1
            ],
            [
                'name' => 'Room 6',
                'spa_id' => 2
            ],
            [
                'name' => 'Room 7',
                'spa_id' => 2
            ],
            [
                'name' => 'Room 8',
                'spa_id' => 2
            ],
            [
                'name' => 'Room 9',
                'spa_id' => 2
            ],
            [
                'name' => 'Room 10',
                'spa_id' => 3
            ],
        ];
    }
}
