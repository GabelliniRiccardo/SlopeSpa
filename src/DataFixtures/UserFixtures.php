<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\DataFixtures\SingleEntityFixture\UserCreator;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUsersData() as $fields) {
            UserCreator::create($manager, $this->password_encoder, $fields);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SPAsFixtures::class,
        );
    }

    private function getUsersData(): array
    {
        return [

            [
                'spa_id' => null,
                'name' => 'Riccardo',
                'last_name' => 'Gabellini',
                'email' => 'gabelliniriccardo.94@gmail.com',
                'password' => 'riccard0',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'spa_id' => null,
                'name' => 'Marco',
                'last_name' => 'Matarazzi',
                'email' => 'mmatarazzi@vendini.com',
                'password' => 'mmmmmmmm',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'spa_id' => 1,
                'name' => 'David',
                'last_name' => 'Senesi',
                'email' => 'davidsenesi@gmail.com',
                'password' => 'david',
                'roles' => ['ROLE_STAFF']
            ],
            [
                'spa_id' => 2,
                'name' => 'Mario',
                'last_name' => 'Rossi',
                'email' => 'mariorossi@gmail.com',
                'password' => 'mari0',
                'roles' => ['ROLE_STAFF']
            ],
        ];
    }
}
