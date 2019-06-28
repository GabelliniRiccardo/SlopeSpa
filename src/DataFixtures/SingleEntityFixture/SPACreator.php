<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\SPA;
use Doctrine\Common\Persistence\ObjectManager;

class SPACreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return SPA
     */
    public static function create(ObjectManager $manager, array $fields = []): SPA
    {
        $spa = new SPA(
            $fields['name'] ?? 'name not found',
            $fields['email'] ?? 'email not found'
        );

        if (!!$fields['address']) {
            $spa->setAddress($fields['address']);
        }

        if (!!$fields['phone_number']) {
            $spa->setPhoneNumber($fields['phone_number']);
        }

        $manager->persist($spa);

        return $spa;
    }
}
