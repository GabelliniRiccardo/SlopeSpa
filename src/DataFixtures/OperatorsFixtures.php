<?php

namespace App\DataFixtures;

use App\DataFixtures\SingleEntityFixture\OperatorCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OperatorsFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        foreach ($this->getOperatorsData() as $fields) {
            OperatorCreator::create($manager, $fields);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SPAsFixtures::class,
        );
    }

    private function getOperatorsData(): array
    {
        return
            [

                // Operators of SPA with ID 1

                [
                    'spa_id' => 1,
                    'first_name' => 'Arianna',
                    'last_name' => 'Riommi',
                    'phone_number' => '3299167609'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Simone',
                    'last_name' => 'Codovini',
                    'phone_number' => '3462342922'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Francesco',
                    'last_name' => 'Bucci',
                    'phone_number' => '3384237556'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Cristina',
                    'last_name' => 'Minelli',
                    'phone_number' => '3331771995'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Diego',
                    'last_name' => 'Izzo',
                    'phone_number' => '3474640373'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Elena',
                    'last_name' => 'Ragni',
                    'phone_number' => '3332631377'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Riccardo',
                    'last_name' => 'Santucci',
                    'phone_number' => '3343353348'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Giovanni',
                    'last_name' => 'Gabbolini',
                    'phone_number' => '3348152592'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Federico',
                    'last_name' => 'Parroni',
                    'phone_number' => '3387582547'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Claudia',
                    'last_name' => 'Mancini',
                    'phone_number' => '3358156621'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Melissa',
                    'last_name' => 'Selvi',
                    'phone_number' => '3664035472'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Christian',
                    'last_name' => 'Ferranti',
                    'phone_number' => '3337238274'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Elvis',
                    'last_name' => 'Gjeci',
                    'phone_number' => '3890943777'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Lorenzo',
                    'last_name' => 'Fabbri',
                    'phone_number' => '3333553039'
                ],
                [
                    'spa_id' => 1,
                    'first_name' => 'Chiara',
                    'last_name' => 'Montinaro',
                    'phone_number' => '3392264061'
                ],

                // Operators of SPA with ID 2

                [
                    'spa_id' => 2,
                    'first_name' => 'Harry',
                    'last_name' => 'Potter',
                    'phone_number' => '3335683928'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Ron',
                    'last_name' => 'Weasley',
                    'phone_number' => '3335682640'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Hermione',
                    'last_name' => 'Granger',
                    'phone_number' => '3245678467'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Albus',
                    'last_name' => 'Silente',
                    'phone_number' => '3345678039'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Tom',
                    'last_name' => 'Riddle',
                    'phone_number' => '3356786542'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Minerva',
                    'last_name' => 'McGranitt',
                    'phone_number' => '3345678939'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Severus',
                    'last_name' => 'Piton',
                    'phone_number' => '3123456789'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Sirius',
                    'last_name' => 'Black',
                    'phone_number' => '3457891234'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Draco',
                    'last_name' => 'Malfoy',
                    'phone_number' => '3211234509'
                ],
                [
                    'spa_id' => 2,
                    'first_name' => 'Dean',
                    'last_name' => 'Thomas',
                    'phone_number' => '3214567328'
                ],
            ];
    }
}
