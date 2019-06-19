<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\SPACreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SPAsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getSPAsData() as $fields) {
            SPACreator::create($manager, $fields);
        }
        $manager->flush();
    }

    private function getSPAsData(): array
    {
        return [

            [
                'name' => 'SPA_1',
                'email' => 'emailspa1@gmail.com',
                'address' => 'Via SPA 1',
                'phone_number' => '1111111111'
            ],
            [
                'name' => 'SPA_2',
                'email' => 'emailspa2@virgilio.it',
                'address' => 'Via SPA 2',
                'phone_number' => '2222222222'
            ],
            [
                'name' => 'SPA_3',
                'email' => 'emailspa3@hotmail.com',
                'address' => 'Via SPA 3',
                'phone_number' => '3333333333'
            ],
        ];
    }
}
