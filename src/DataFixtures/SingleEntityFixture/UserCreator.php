<?php

namespace App\DataFixtures\SingleEntityFixture;

use App\Entity\SPA;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreator
{

    /**
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $password_encoder
     * @param mixed[] $fields
     * @return User
     */
    public static function create(ObjectManager $manager, UserPasswordEncoderInterface $password_encoder, array $fields = []): User
    {
        $user = new User(
            $fields['name'] ?? 'name not found',
            $fields['last_name'] ?? 'last name not found',
            $fields['email'] ?? 'email not found',
            $fields['password'] ?? 'password not found',
            $fields['roles'] ?? ['role not found']
        );

        $user->setPassword($password_encoder->encodePassword($user, $user->getPassword()));

        if (!!$fields['spa_id']){
            $spa = $manager->getRepository(SPA::class)->findOneBy(['id' => $fields['spa_id']]);
            $user->setSPA($spa);
        }

        $manager->persist($user);

        return $user;
    }
}
