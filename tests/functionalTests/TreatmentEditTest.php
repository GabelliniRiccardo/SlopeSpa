<?php


namespace App\Tests\functionalTests;


class TreatmentEditTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testEditTreatmentPage()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/treatment/edit/1');
        $treatmentName = $this->actor->findOrFail('[name="edit_treatment_form[treatment][name]"]');
        $treatmentPrice = $this->actor->findOrFail('[name="edit_treatment_form[treatment][money][value]"]');
        $treatmentHours = $this->actor->findOrFail('[name="edit_treatment_form[treatment][duration][hour]"]');
        $treatmentMinutes = $this->actor->findOrFail('[name="edit_treatment_form[treatment][duration][minute]"]');
        $treatmentVat = $this->actor->findOrFail('[name="edit_treatment_form[treatment][vat]"]');

        self::assertSame($treatmentName->getValue(), 'Kembiki Massage');
        self::assertSame($treatmentPrice->getValue(), '50.00');
        self::assertSame($treatmentHours->getValue(), '1');
        self::assertSame($treatmentMinutes->getValue(), '0');
        self::assertSame($treatmentVat->getValue(), '22.0');
    }

    public function testEditTreatmentSuccess()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/treatment/edit/1');

        $newName = 'Treatment Test';
        $newPrice = 220;
        $newHour = 10;
        $newMinute = 50;
        $newVat = 50;

        $this->actor->addTextOnInputField('[name="edit_treatment_form[treatment][name]"]', $newName);
        $this->actor->addTextOnInputField('[name="edit_treatment_form[treatment][money][value]"]', $newPrice);
        $this->actor->selectOption('edit_treatment_form[treatment][duration][hour]', $newHour);
        $this->actor->selectOption('edit_treatment_form[treatment][duration][minute]', $newMinute);
        $this->actor->addTextOnInputField('[name="edit_treatment_form[treatment][vat]"]', $newVat);
        $this->actor->clickOn('[name="edit_treatment_form[edit]"]');

        $this->actor->visit('/staff/treatment/edit/1');

        $treatmentName = $this->actor->findOrFail('[name="edit_treatment_form[treatment][name]"]');
        $treatmentPrice = $this->actor->findOrFail('[name="edit_treatment_form[treatment][money][value]"]');
        $treatmentHours = $this->actor->findOrFail('[name="edit_treatment_form[treatment][duration][hour]"]');
        $treatmentMinutes = $this->actor->findOrFail('[name="edit_treatment_form[treatment][duration][minute]"]');
        $treatmentVat = $this->actor->findOrFail('[name="edit_treatment_form[treatment][vat]"]');

        self::assertSame($treatmentName->getValue(), $newName);
        self::assertSame($treatmentPrice->getValue(), (string)(number_format($newPrice, 2, '.', '')));
        self::assertSame($treatmentHours->getValue(), (string)$newHour);
        self::assertSame($treatmentMinutes->getValue(), (string)$newMinute);
        self::assertSame($treatmentVat->getValue(), (string)(number_format($newVat, 1, '.', '')));
    }

    public function testEditTreatmentFail()
    {
        $this->actor->visit('/login');
        $this->actor->loginAsStaffUser();
        $this->actor->visit('/staff/treatment/edit/100');
        self::assertSame($this->actor->getStatusCode(), 404);
    }
}
