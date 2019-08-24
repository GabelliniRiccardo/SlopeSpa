<?php


namespace App\Tests\functionalTests;


class ReservationEditTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testEditReservationSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/reservation/edit/1');
        $this->actor->selectOption('edit_reservation_form[reservation][customer]', 2);
        $this->actor->clickOn('[name="edit_reservation_form[edit]"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/reservation/pastlist');
    }

    public function testEditButtonOnReservationList()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/reservation/futurelist');
        $this->actor->clickOn('[data-test="edit-reservation-19"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/reservation/edit/19');
    }
}
