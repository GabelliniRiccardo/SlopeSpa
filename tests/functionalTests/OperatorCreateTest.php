<?php


namespace App\Tests\functionalTests;


class OperatorCreateTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateOperatorSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/operator/create');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][firstName]"]', 'Operator first name');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][lastName]"]', 'Operator last name');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][phoneNumber]"]', '1111111111');
        $this->actor->clickOn('[name="create_operator_form[create]"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/operator/list');
    }

    public function testCreateOperatorInsuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/operator/create');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][firstName]"]', 'Operator first name');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][lastName]"]', 'Operator last name');
        $this->actor->addTextOnInputField('[name="create_operator_form[operator][phoneNumber]"]', '1111111111sssssssss');
        $this->actor->clickOn('[name="create_operator_form[create]"]');
        $nodeElement = $this->actor->findOrFail('.form-error-message');
        self::assertSame($nodeElement->getText(), 'Insert numbers only');
    }
}
