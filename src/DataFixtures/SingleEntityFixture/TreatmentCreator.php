<?php


namespace App\DataFixtures\SingleEntityFixture;


use App\Entity\Operator;
use App\Entity\Room;
use App\Entity\SPA;
use App\Entity\Treatment;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use \Symfony\Component\Config\Definition\Exception\Exception;

class TreatmentCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Treatment
     */
    public static function create(ObjectManager $manager, array $fields = []): Treatment
    {
        $room_list = new ArrayCollection();
        foreach ($fields['rooms_ids'] as $room_id) {
            $room = $manager->getRepository(Room::class)->findOneBy(['id' => $room_id]);
            if (is_null($room)) {
                throw new Exception('Room with id: ' . $room_id . ' not found');
            }
            $room_list->add($room);

        }

        $operator = $manager->getRepository(Operator::class)->findOneBy(['id' => $fields['operator_id']]);
        if (is_null($operator)) {
            throw new Exception('Operator with id: ' . $fields['operator_id'] . ' not found');
        }

        $spa = $manager->getRepository(SPA::class)->findOneBy(['id' => $fields['spa_id']]);
        if (is_null($spa)) {
            throw new Exception('Spa with id: ' . $fields['spa_id'] . ' not found');
        }

        $treatment = new Treatment(
            $fields['name'] ?? 'name not found',
            $fields['price'] ?? 'price not found',
            $fields['duration'] ?? 'duration not found',
            $fields['VAT'] ?? 22,
            $operator,
            $room_list,
            $spa
        );

        $manager->persist($treatment);

        return $treatment;
    }

}
