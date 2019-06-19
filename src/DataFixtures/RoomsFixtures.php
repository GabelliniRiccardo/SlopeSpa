<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\RoomCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoomsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->loadRoomsData() as $fields) {
            RoomCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    private function loadRoomsData(): array
    {
        return [
            [
                'name' => 'Room 1'
            ],
            [
                'name' => 'Room 2'
            ],
            [
                'name' => 'Room 3'
            ],
            [
                'name' => 'Room 4'
            ],
            [
                'name' => 'Room 5'
            ],
            [
                'name' => 'Room 6'
            ],
            [
                'name' => 'Room 7'
            ],
            [
                'name' => 'Room 8'
            ],
            [
                'name' => 'Room 9'
            ],
            [
                'name' => 'Room 10'
            ],
        ];
    }
}
