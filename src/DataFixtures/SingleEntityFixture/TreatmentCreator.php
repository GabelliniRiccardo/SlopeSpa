<?php


namespace App\DataFixtures\SingleEntityFixture;


use App\Entity\Operator;
use App\Entity\Room;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
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
        $spa = $manager->getRepository(SPA::class)->find($fields['spa_id']);
        if (is_null($spa)) {
            throw new Exception('Spa with id: ' . $fields['spa_id'] . ' not found');
        }

        $money = new Money($fields['price'] ?? 100, 'EURO');

        $treatment = new Treatment(
            $fields['name'] ?? 'name not found',
            $money,
            $fields['duration'] ?? 'duration not found',
            $fields['VAT'] ?? 22,
            $spa
        );

        foreach ($fields['rooms_ids'] as $room_id) {
            $room = $manager->getRepository(Room::class)->find($room_id);
            if (is_null($room)) {
                throw new Exception('Room with id: ' . $room_id . ' not found');
            }
            $treatment->addRoom($room);

        }

        $operator = $manager->getRepository(Operator::class)->find($fields['operator_id']);
        if (is_null($operator)) {
            throw new Exception('Operator with id: ' . $fields['operator_id'] . ' not found');
        }

        $treatment->addOperator($operator);

        $manager->persist($treatment);

        return $treatment;
    }
}
