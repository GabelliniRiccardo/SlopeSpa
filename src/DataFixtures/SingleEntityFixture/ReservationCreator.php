<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\Customer;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\SPA;
use App\Entity\Treatment;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Config\Definition\Exception\Exception;

class ReservationCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Reservation
     */
    public static function create(ObjectManager $manager, array $fields = []): Reservation
    {
        $spa = $manager->getRepository(SPA::class)->findOneBy(['id' => $fields['spa_id']]);
        $treatment = $manager->getRepository(Treatment::class)->findOneBy(['id' => $fields['treatment_id']]);
        $room = $manager->getRepository(Room::class)->findOneBy(['id' => $fields['room_id']]);
        $customer = $manager->getRepository(Customer::class)->findOneBy(['id' => $fields['customer_id']]);

        if (is_null($treatment)) {
            throw new Exception('SPA with id : ' . $fields['spa_id'] . ' not found');
        }

        if (is_null($treatment)) {
            throw new Exception('Treatment with id : ' . $fields['treatment_id'] . ' not found');
        }

        if (is_null($room)) {
            throw new Exception('Room with id : ' . $fields['room_id'] . ' not found');
        }

        if (is_null($customer)) {
            throw new Exception('Customer with id : ' . $fields['customer_id'] . ' not found');
        }

        $reservation = new Reservation(
            $fields['start_time'] ?? 'start time not found',
            $fields['end_time'] ?? 'end time not found',
            $fields['duration'] ?? 'duration not found',
            $fields['price'] ?? 'price not found',
            $treatment,
            $room,
            $customer,
            $fields['vat'] ?? 22,
            $spa
        );


        $manager->persist($reservation);

        return $reservation;
    }
}
