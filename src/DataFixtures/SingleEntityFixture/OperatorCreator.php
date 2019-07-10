<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\Operator;
use App\Entity\SPA;
use Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Config\Definition\Exception\Exception;

class OperatorCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Operator
     */
    public static function create(ObjectManager $manager, array $fields = []): Operator
    {
        $spa = $manager->getRepository(SPA::class)->find($fields['spa_id']);
        if (is_null($spa)) {
            throw new Exception('spa with id: ' . $fields['spa_id'] . ' not found');
        }
        $operator = new Operator(
            $fields['first_name'] ?? 'name not found',
            $fields['last_name'] ?? 'last name not found',
            $spa
        );

        if (!!$fields['phone_number']) {
            $operator->setPhoneNumber($fields['phone_number']);
        }

        $manager->persist($operator);

        return $operator;
    }
}
