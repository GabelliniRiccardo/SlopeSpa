<?php

namespace App\Tests\unitTests;

use App\Entity\SPA;
use PHPUnit\Framework\TestCase;

class SpaTest extends TestCase
{
    public function testConstructor()
    {
        $spaName = 'Spa';
        $spaEmail = 'emailspa@gmail.com';

        $spa = new SPA($spaName, $spaEmail);

        $this->assertSame($spa->getName(), $spaName);
        $this->assertSame($spa->getEmail(), $spaEmail);
    }
}
