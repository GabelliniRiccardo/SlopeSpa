<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\Customer;
use App\Entity\Operator;
use App\Entity\Reservation;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
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
        $spa = $manager->getRepository(SPA::class)->find($fields['spa_id']);
        $treatment = $manager->getRepository(Treatment::class)->find($fields['treatment_id']);
        $customer = $manager->getRepository(Customer::class)->find($fields['customer_id']);
        $operator = $manager->getRepository(Operator::class)->find($fields['operator_id']);

        if (is_null($treatment)) {
            throw new Exception('SPA with id : ' . $fields['spa_id'] . ' not found');
        }

        if (is_null($treatment)) {
            throw new Exception('Treatment with id : ' . $fields['treatment_id'] . ' not found');
        }

        if (is_null($customer)) {
            throw new Exception('Customer with id : ' . $fields['customer_id'] . ' not found');
        }

        if (is_null($operator)) {
            throw new Exception('Operator with id : ' . $fields['operator_id'] . ' not found');
        }

        $reservation = new Reservation(
            $fields['start_time'] ?? 'start time not found',
            $fields['end_time'] ?? 'end time not found',
            $fields['duration'] ?? 'duration not found',
            new Money($fields['price'] ?? 100),
            $treatment,
            $customer,
            $fields['vat'] ?? 22,
            $spa,
            $operator
        );


        $manager->persist($reservation);

        return $reservation;
    }
}
