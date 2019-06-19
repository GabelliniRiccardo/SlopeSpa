<?php


namespace App\DataFixtures\SingleEntityFixture;


use App\Entity\Room;
use Doctrine\Common\Persistence\ObjectManager;

class RoomCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return SPA
     */
    public static function create(ObjectManager $manager, array $fields = []): Room
    {
        $room = new Room(
            $fields['name'] ?? 'name not found'
        );

        $manager->persist($room);

        return $room;
    }
}
