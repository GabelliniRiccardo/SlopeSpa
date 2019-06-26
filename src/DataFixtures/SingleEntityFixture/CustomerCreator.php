<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\Customer;
use App\Entity\SPA;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Config\Definition\Exception\Exception;

class CustomerCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Customer
     */
    public static function create(ObjectManager $manager, array $fields = []): Customer
    {

        $spa = $manager->getRepository(SPA::class)->findOneBy(['id' => $fields['spa_id']]);
        if (is_null($spa)) {
            throw new Exception('Spa with id: ' . $fields['spa_id'] . ' not found');
        }


        $customer = new Customer(
            $fields['first_name'] ?? 'name not found',
            $fields['last_name'] ?? 'last name not found',
            $spa
        );

        if (!!$fields['birthday']) {
            $customer->setBirthday($fields['birthday']);
        }

        if (!!$fields['address']) {
            $customer->setAddress($fields['address']);
        }

        if (!!$fields['phone_number']) {
            $customer->setPhoneNumber($fields['phone_number']);
        }

        $manager->persist($customer);

        return $customer;
    }
}
