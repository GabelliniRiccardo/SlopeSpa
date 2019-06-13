<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$name, $last_name, $email, $password, $roles])
        {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [

            ['Riccardo', 'Gabellini', 'gabelliniriccardo.94@gmail.com', 'riccard0', ['ROLE_ADMIN']],
            ['Mario', 'Rossi', 'mariorossi@gmail.com', 'mari0', ['ROLE_STAFF']],
            ['Elena', 'Rossi', 'elenarossi@gmail.com', 'elena', ['ROLE_OPERATOR']],
        ];
    }
}
