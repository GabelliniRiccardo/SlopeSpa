<?php


namespace App\Tests\functionalTests;


class TreatmentCreateTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateTreatmentSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/treatment/create');
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][name]"]', 'Treatment Test');
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][money][value]"]', 220);
        $this->actor->selectOption('create_treatment_form[treatment][duration][hour]', 1);
        $this->actor->selectOption('create_treatment_form[treatment][duration][minute]', 0);
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][vat]"]', 22);
        $this->actor->clickOn('[name="create_treatment_form[create]"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/treatment/list');
    }

    public function testCreateTreatmentInsuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/treatment/create');
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][name]"]', 'Treatment Test');
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][money][value]"]', 220 . 'fail');
        $this->actor->selectOption('create_treatment_form[treatment][duration][hour]', 1);
        $this->actor->selectOption('create_treatment_form[treatment][duration][minute]', 0);
        $this->actor->addTextOnInputField('[name="create_treatment_form[treatment][vat]"]', 22);
        $this->actor->clickOn('[name="create_treatment_form[create]"]');
        self::assertSame($this->actor->getCurrentUrl(), $this->actor->getBaseUrl() . '/staff/treatment/create');
        $nodeElement = $this->actor->findOrFail('.form-error-message');
        self::assertSame($nodeElement->getText(), "This value is not valid.");
    }
}
