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
                'name' => 'Wellness Spa',
                'email' => 'wellness.spa@gmail.com',
                'address' => 'Via Liguria 7',
                'phone_number' => '0758560403'
            ],
            [
                'name' => 'Spring Spa',
                'email' => 'springspa@virgilio.it',
                'address' => 'Via dei martiti 11',
                'phone_number' => '0575735646'
            ],
        ];
    }
}
