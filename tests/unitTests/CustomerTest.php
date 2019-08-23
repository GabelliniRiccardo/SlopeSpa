<?php

namespace App\Tests\unitTests;

use App\Entity\Customer;
use App\Entity\SPA;
use PHPUnit\Framework\TestCase;


class CustomerTest extends TestCase
{
    public function testConstructor()
    {
        $spaName = 'Spa';
        $spaEmail = 'emailspa@gmail.com';
        $customerFirstName = 'Customer First Name';
        $customerLastName = 'Customer Last Name';

        $spa = new SPA($spaName, $spaEmail);
        $customer = new Customer($customerFirstName, $customerLastName, $spa);

        $this->assertSame($customer->getSpa(), $spa);
        $this->assertSame($customer->getFirstName(), $customerFirstName);
        $this->assertSame($customer->getLastName(), $customerLastName);
        $this->assertEquals(sizeof($customer->getReservations()), 0);
    }
}
