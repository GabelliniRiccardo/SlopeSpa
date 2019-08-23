<?php


namespace App\Tests\functionalTests;


class LoginPageTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSkipLogin(){
        $this->actor->visit('/staff/dashboard');
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/login');
    }

    public function testLoginWithCorrectCredentialsOfStaffUser()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/dashboard');
    }

    public function testLoginWithInCorrectCredentialsOfStaffUser()
    {
        $this->actor->visit('/login');
        $this->actor->addTextOnInputField('[data-test="login-email"]', 'davidsenesi@gmail.com');
        $this->actor->addTextOnInputField('[data-test="login-password"]', 'incorrect password');
        $this->actor->clickOn('[data-test="login-button"]');
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/login');
    }

    public function testLoginWithInCorrectCredentialsOfAdminUser()
    {
        $this->actor->visit('/login');
        $this->actor->addTextOnInputField('[data-test="login-email"]', 'gabelliniriccardo.94@gmail.com');
        $this->actor->addTextOnInputField('[data-test="login-password"]', 'incorrect password');
        $this->actor->clickOn('[data-test="login-button"]');
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/login');
    }

    public function testLoginWithCorrectCredentialsOfAdminUser()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsAdminUser();
        self::assertEquals($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/admin/dashboard');
    }
}
