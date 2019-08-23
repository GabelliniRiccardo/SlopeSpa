<?php


namespace App\Tests\functionalTests;


class CustomerCreateTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateCustomerSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/customer/create');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][firstName]"]', 'Customer first name');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][lastName]"]', 'Customer last name');
        $this->actor->selectOption('create_customer_form[customer][birthday][month]', 6);
        $this->actor->selectOption('create_customer_form[customer][birthday][day]', 3);
        $this->actor->selectOption('create_customer_form[customer][birthday][year]', 1990);
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][address]"]', 'Address test');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][phoneNumber]"]', '1111111111');
        $this->actor->clickOn('[name="create_customer_form[create]"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/customer/list');
    }

    public function testCreateCustomerInsuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/customer/create');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][firstName]"]', 'Customer first name');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][lastName]"]', 'Customer last name');
        $this->actor->selectOption('create_customer_form[customer][birthday][month]', 6);
        $this->actor->selectOption('create_customer_form[customer][birthday][day]', 3);
        $this->actor->selectOption('create_customer_form[customer][birthday][year]', 1990);
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][address]"]', 'Address test');
        $this->actor->addTextOnInputField('[name="create_customer_form[customer][phoneNumber]"]', '1111111111sss'); // here is the error
        $this->actor->clickOn('[name="create_customer_form[create]"]');
        $nodeElement = $this->actor->findOrFail('.form-error-message');
        self::assertSame($nodeElement->getText(), 'Insert numbers only');
    }
}
