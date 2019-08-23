<?php

namespace App\Tests\integrationTests\RepositoryTests;

use App\Entity\User;
use App\Tests\integrationTests\BaseIntegrationTest;

class UserRepositoryTest extends BaseIntegrationTest
{
    private $userRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function testfindUserByEmail(){
        $user = $this->userRepository->findUserByEmail('davidsenesi@gmail.com');
        $correctUser = $this->userRepository->find(3);
        self::assertSame($user, $correctUser);
    }

    public function testFindAll()
    {
        $users = $this->userRepository->findAll();
        $this->assertSame(sizeof($users), 4);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
