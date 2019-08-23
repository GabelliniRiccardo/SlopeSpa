<?php

namespace App\Tests\unitTests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructor()
    {
        $firstName = 'User First Name';
        $lastName = 'User Last Name';
        $email = 'useremail@gmail.com';
        $password = 'userpassword';
        $roles = ['ROLE_ADMIN'];
        $user = new User($firstName, $lastName, $email, $password, $roles);

        $this->assertSame($user->getName(), $firstName);
        $this->assertSame($user->getLastName(), $lastName);
        $this->assertSame($user->getEmail(), $email);
        $this->assertSame($user->getPassword(), $password);
        $this->assertSame($user->getRoles(), $roles);
    }
}
