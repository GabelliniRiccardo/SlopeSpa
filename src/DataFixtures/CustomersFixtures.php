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
        return
            [
                // Customers of SPA with ID 1

                [
                    'first_name' => 'Anna',
                    'last_name' => 'Cardosi',
                    'birthday' => new \DateTimeImmutable('1958-10-08'),
                    'address' => 'C.S. Sorbello 41',
                    'phone_number' => '3339306024',
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
                    'first_name' => 'Tommaso',
                    'last_name' => 'Cesari',
                    'birthday' => new \DateTimeImmutable('1994-08-08'),
                    'address' => 'Via senese 7',
                    'phone_number' => '3924745186',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Oredana',
                    'last_name' => 'Valentini',
                    'birthday' => new \DateTimeImmutable('1963-11-09'),
                    'address' => 'Via Degli Alfieri 10/c',
                    'phone_number' => '3358398193',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Roberto',
                    'last_name' => 'Gabellini',
                    'birthday' => new \DateTimeImmutable('1961-12-19'),
                    'address' => 'Via Degli Alfieri 10/c',
                    'phone_number' => '3385924790',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Sara',
                    'last_name' => 'Mazzini',
                    'birthday' => new \DateTimeImmutable('2000-03-22'),
                    'address' => 'Via dei Forestali 23',
                    'phone_number' => '3391745441',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Antonello',
                    'last_name' => 'Bondi',
                    'birthday' => new \DateTimeImmutable('1961-06-08'),
                    'address' => 'Via del sole 7',
                    'phone_number' => '3462237521',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Giuseppina',
                    'last_name' => 'Gabellini',
                    'birthday' => new \DateTimeImmutable('1967-10-20'),
                    'address' => 'Via del sole 7',
                    'phone_number' => '3463891259',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Marina',
                    'last_name' => 'Valentini',
                    'birthday' => new \DateTimeImmutable('1968-09-15'),
                    'address' => 'Via dei forestali 23',
                    'phone_number' => '3336828741',
                    'spa_id' => 1
                ],
                [
                    'first_name' => 'Giovanni',
                    'last_name' => 'Mazzini',
                    'birthday' => new \DateTimeImmutable('1964-09-15'),
                    'address' => 'Via dei forestali 23',
                    'phone_number' => '3401075284',
                    'spa_id' => 1
                ],


                // Customers of SPA with ID 2

                [
                    'first_name' => 'Luna',
                    'last_name' => 'Lovegood',
                    'birthday' => new \DateTimeImmutable('1993-05-08'),
                    'address' => 'Via delle magnolie 3',
                    'phone_number' => '3567345872',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Cho',
                    'last_name' => 'Chang',
                    'birthday' => new \DateTimeImmutable('1993-04-03'),
                    'address' => 'Via della vittoria 3',
                    'phone_number' => '3456753213',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Ted',
                    'last_name' => 'Tonks',
                    'birthday' => new \DateTimeImmutable('1991-01-01'),
                    'address' => 'Via della galassia 3',
                    'phone_number' => '3456798765',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Remus',
                    'last_name' => 'Lupin',
                    'birthday' => new \DateTimeImmutable('1983-03-08'),
                    'address' => 'Via dei burattini 2',
                    'phone_number' => '3134509876',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Peter',
                    'last_name' => 'Minus',
                    'birthday' => new \DateTimeImmutable('1985-02-02'),
                    'address' => 'Via cavour 1',
                    'phone_number' => '3567345872',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Pomona',
                    'last_name' => 'Sprite',
                    'birthday' => new \DateTimeImmutable('1975-05-01'),
                    'address' => 'Via delle magnolie 3',
                    'phone_number' => '3567345872',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Vernon',
                    'last_name' => 'Dursley',
                    'birthday' => new \DateTimeImmutable('1993-05-04'),
                    'address' => 'Viale quartetti 81',
                    'phone_number' => '3456213489',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Godric',
                    'last_name' => 'Grifondoro',
                    'birthday' => new \DateTimeImmutable('1934-09-01'),
                    'address' => 'Via del canederlo 56',
                    'phone_number' => '3245678432',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Priscilla',
                    'last_name' => 'Corvonero',
                    'birthday' => new \DateTimeImmutable('1945-03-09'),
                    'address' => 'Via del gesso 6',
                    'phone_number' => '3567345872',
                    'spa_id' => 2
                ],
                [
                    'first_name' => 'Viktor',
                    'last_name' => 'Krum',
                    'birthday' => new \DateTimeImmutable('1967-07-09'),
                    'address' => 'Via del giocoliere 21',
                    'phone_number' => '34501235234',
                    'spa_id' => 2
                ],
            ];
    }
}
