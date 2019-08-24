<?php


namespace App\Tests\functionalTests;


class ReservationDeleteTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testDeleteReservationSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/reservation/futurelist');

        $this->actor->clickOn('[data-test="delete-reservation-19"]');
        $this->actor->shouldSeeElement('[data-test="delete-reservation-modal"]');
        $this->actor->clickOn('[name="delete_reservation_form[Delete]"]');
        $this->actor->shouldNotSee('[data-test="delete-reservation-19"]');
    }
}
