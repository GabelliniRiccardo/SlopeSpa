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
        return [
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
                'first_name' => 'Lorenzo',
                'last_name' => 'Fabbri',
                'phone_number' => '3333553039'
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
        ];
    }
}
