<?php


namespace App\DataFixtures\SingleEntityFixture;


use App\Entity\Room;
use App\Entity\SPA;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Config\Definition\Exception\Exception;

class RoomCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Room
     */
    public static function create(ObjectManager $manager, array $fields = []): Room
    {
        $spa = $manager->getRepository(SPA::class)->find($fields['spa_id']);
        if (is_null($spa)) {
            throw new Exception('Spa with id: ' . $fields['spa_id'] . ' not found');
        }

        $room = new Room(
            $fields['name'] ?? 'name not found',
            $spa
        );

        $manager->persist($room);

        return $room;
    }
}
