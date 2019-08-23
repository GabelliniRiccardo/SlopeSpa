<?php


namespace App\Tests\functionalTests;


class CalendarTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSwitchView()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/calendar/');
        $this->actor->shouldSee('Vertical View');
        $this->actor->clickOn('[class="v-switch-core"]');
        $this->actor->shouldSee('Horizontal View');
    }
}
