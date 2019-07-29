<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\CustomerCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CustomersFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        foreach ($this->getCustomersData() as $fields) {
            CustomerCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            SPAsFixtures::class,
        );
    }

    private function getCustomersData(): array
    {
        return [
            [
                'first_name' => 'Anno',
                'last_name' => 'Cardosi',
                'birthday' => new \DateTimeImmutable('1958-10-08'),
                'address' => 'C.S. Sorbello 41',
                'phone_number' => '3339306024',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Massimo',
                'last_name' => 'Montinaro',
                'birthday' => new \DateTimeImmutable('1957-06-02'),
                'address' => 'C.S. Sorbello 41',
                'phone_number' => '3339102499',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Giada',
                'last_name' => 'Montinaro',
                'birthday' => new \DateTimeImmutable('1984-05-20'),
                'address' => 'San lorenzo 52',
                'phone_number' => '3401010287',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Montinaro',
                'birthday' => new \DateTimeImmutable('1981-12-17'),
                'address' => 'C.S. Sorbello 41',
                'phone_number' => '3924745186',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Chiara',
                'last_name' => 'Montinaro',
                'birthday' => new \DateTimeImmutable('1994-11-04'),
                'address' => 'C.S. Sorbello 41',
                'phone_number' => '3392264061',
                'spa_id' => 1
            ],
        ];
    }
}
