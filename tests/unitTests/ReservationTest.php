<?php

namespace App\Tests\unitTests;

use App\Entity\Customer;
use App\Entity\Operator;
use App\Entity\Reservation;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testConstructor()
    {

        $start_time = new \DateTimeImmutable();
        $end_time = new \DateTimeImmutable();
        $name = 'Treatment';
        $money = new Money(100);
        $duration = 3600;
        $vat = 22.0;
        $spaName = 'Spa';
        $spaEmail = 'emailspa@gmail.com';
        $spa = new SPA($spaName, $spaEmail);
        $treatment = new Treatment($name, $money, $duration, $vat, $spa);
        $customerFirstName = 'Customer First Name';
        $customerLastName = 'Customer Last Name';
        $spa = $treatment->getSpa();
        $customer = new Customer($customerFirstName, $customerLastName, $spa);
        $vat = 22.0;
        $operatorFirstName = 'Operator First Name';
        $operatorLastName = 'Operator Last Name';
        $operator = new Operator($operatorFirstName, $operatorLastName, $spa);

        $reservation = new Reservation($start_time, $end_time, $duration, $money, $treatment, $customer, $vat, $spa, $operator);

        $this->assertSame($reservation->getStartTime(), $start_time);
        $this->assertSame($reservation->getEndTime(), $end_time);
        $this->assertSame($reservation->getDuration(), $duration);
        $this->assertSame($reservation->getMoney(), $money);
        $this->assertSame($reservation->getTreatment(), $treatment);
        $this->assertSame($reservation->getCustomer(), $customer);
        $this->assertSame($reservation->getVat(), $vat);
        $this->assertSame($reservation->getSpa(), $spa);
        $this->assertSame($reservation->getOperator(), $operator);
    }
}
