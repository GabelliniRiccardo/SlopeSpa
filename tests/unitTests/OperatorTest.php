<?php

namespace App\Tests\unitTests;

use App\Entity\Operator;
use App\Entity\SPA;
use PHPUnit\Framework\TestCase;

class OperatorTest extends TestCase
{
    public function testConstructor()
    {
        $firstName = 'OperatorFirstName';
        $lastName = 'OperatorLastName';
        $spaName = 'Spa';
        $spaEmail = 'emailspa@gmail.com';
        $spa = new SPA($spaName, $spaEmail);

        $operator = new Operator($firstName, $lastName, $spa);

        $this->assertSame($operator->getFirstName(), $firstName);
        $this->assertSame($operator->getLastName(), $lastName);
        $this->assertSame($operator->getSpa(), $spa);
    }
}
