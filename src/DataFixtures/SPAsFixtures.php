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
            [
                'name' => 'SPA_4',
                'email' => 'emailspa4@hotmail.com',
                'address' => 'Via SPA 4',
                'phone_number' => '4444444444'
            ],
            [
                'name' => 'SPA_5',
                'email' => 'emailspa5@hotmail.com',
                'address' => 'Via SPA 5',
                'phone_number' => '5555555555'
            ],
            [
                'name' => 'SPA_6',
                'email' => 'emailspa6@hotmail.com',
                'address' => 'Via SPA 6',
                'phone_number' => '6666666666'
            ],
            [
                'name' => 'SPA_7',
                'email' => 'emailspa7@hotmail.com',
                'address' => 'Via SPA 7',
                'phone_number' => '7777777777'
            ],
            [
                'name' => 'SPA_8',
                'email' => 'emailspa8@hotmail.com',
                'address' => 'Via SPA 8',
                'phone_number' => '8888888888'
            ],
            [
                'name' => 'SPA_9',
                'email' => 'emailspa9@hotmail.com',
                'address' => 'Via SPA 9',
                'phone_number' => '9999999999'
            ],
            [
                'name' => 'SPA_10',
                'email' => 'emailspa10@hotmail.com',
                'address' => 'Via SPA 10',
                'phone_number' => '1010101010'
            ],
            [
                'name' => 'SPA_11',
                'email' => 'emailspa11@hotmail.com',
                'address' => 'Via SPA 11',
                'phone_number' => '1111111111'
            ],
        ];
    }
}
