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
                'first_name' => 'Customer 1 first_name',
                'last_name' => 'Customer 1 last_name',
                'birthday' => new \DateTimeImmutable('1994-01-01'),
                'address' => 'Address of customer 1',
                'phone_number' => '1111111111',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Customer 2 first_name',
                'last_name' => 'Customer 2 last_name',
                'birthday' => new \DateTimeImmutable('1981-07-09'),
                'address' => 'Address of customer 1',
                'phone_number' => '2222222222',
                'spa_id' => 1
            ],
            [
                'first_name' => 'Customer 3 first_name',
                'last_name' => 'Customer 3 last_name',
                'birthday' => new \DateTimeImmutable('1979-04-04'),
                'address' => 'Address of customer 1',
                'phone_number' => '2222222222',
                'spa_id' => 2
            ],
        ];
    }
}
