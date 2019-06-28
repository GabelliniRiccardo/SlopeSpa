<?php


namespace App\Service\DomainManager;


use App\Entity\User;
use App\Model\DTO\UserDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $entityManager;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function create(UserDTO $userDTO): User
    {
        $name = $userDTO->name;
        $lastName = $userDTO->lastName;
        $email = $userDTO->email;
        $password = $userDTO->password;
        $spa = $userDTO->spa;

        $user = new User($name, $lastName, $email, $password, ['ROLE_STAFF']);
        $user->setSpa($spa);
        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function update(UserDTO $userDTO): User
    {
        $id = $userDTO->id;
        $name = $userDTO->name;
        $lastName = $userDTO->lastName;
        $email = $userDTO->email;
        $password = $userDTO->password;
        $roles = $userDTO->roles;
        $spa = $userDTO->spa;

        $user = $this->entityManager->getRepository(User::class)->find($id);

        $user->setName($name);
        $user->setlastName($lastName);
        $user->setEmail($email);
        $encoded = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encoded);
        $user->setRoles($roles);
        $user->setSpa($spa);

        $this->entityManager->persist($spa);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
