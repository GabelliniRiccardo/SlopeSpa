<?php


namespace App\Tests\functionalTests;


class OperatorEditTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testEditButtonOnOperatorList()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/operator/list');
        $this->actor->clickOn('[data-test="edit-operator-4"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/operator/edit/4');
    }
}
