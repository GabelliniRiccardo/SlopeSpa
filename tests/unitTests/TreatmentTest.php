<?php

namespace App\Tests\unitTests;

use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
use PHPUnit\Framework\TestCase;

class TreatmentTest extends TestCase
{
    public function testConstructor()
    {
        $name = 'Treatment';
        $money = new Money(100);
        $duration = 3600;
        $vat = 22.0;
        $spaName = 'Spa';
        $spaEmail = 'emailspa@gmail.com';
        $spa = new SPA($spaName, $spaEmail);

        $treatment = new Treatment($name, $money, $duration, $vat, $spa);

        $this->assertSame($treatment->getName(), $name);
        $this->assertSame($treatment->getMoney(), $money);
        $this->assertSame($treatment->getMoney()->getCurrency(), 'EUR');
        $this->assertSame($treatment->getDuration(), $duration);
        $this->assertSame($treatment->getVat(), $vat);
        $this->assertSame($treatment->getSpa(), $spa);
        $this->assertEquals(sizeof($treatment->getOperators()), 0);
        $this->assertEquals(sizeof($treatment->getReservations()), 0);
    }
}
