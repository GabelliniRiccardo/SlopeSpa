<?php


namespace App\Tests\functionalTests;


class HomePageTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    function testHome()
    {
        $this->actor->visit('/');
        $this->actor->clickOn('[data-test="login"]');
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/login');
        $this->actor->clickOn('[data-test="home"]');
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/');
    }
}
