<?php

namespace App\Tests\integrationTests\ManagerTests;

use App\Entity\SPA;
use App\Entity\Treatment;
use App\Model\DTO\TreatmentDTO;
use App\Objects\Money;
use App\Service\DomainManager\TreatmentManager;
use App\Tests\integrationTests\BaseIntegrationTest;

class TreatmentManagerTest extends BaseIntegrationTest
{
    private $treatmentManager;

    public function setUp()
    {
        parent::setUp();
        $this->treatmentManager = self::$container->get(TreatmentManager::class);
    }

    public function testCreate()
    {
        $name = 'Treatment Test';
        $money = new Money(100);
        $duration = 3600;
        $vat = 22.0;

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);

        $treatmentDTO = new TreatmentDTO($spa);
        $treatmentDTO->name = $name;
        $treatmentDTO->money = $money;
        $treatmentDTO->duration = $duration;
        $treatmentDTO->vat = $vat;
        $treatment = $this->treatmentManager->create($treatmentDTO);

        $this->assertSame($treatment->getName(), $name);
        $this->assertSame($treatment->getMoney()->getValue(), $money->getValue());
        $this->assertSame($treatment->getDuration(), $duration);
        $this->assertSame($treatment->getVat(), $vat);
    }

    public function testUpdate()
    {
        $id = 1;
        $newName = 'Treatment Test';
        $newMoney = new Money(100);
        $newDuration = 3600;
        $newVat = 22.0;

        $spa = $this->entityManager->getRepository(SPA::class)->find(1);

        $treatmentDTO = new TreatmentDTO($spa);
        $treatmentDTO->id = $id;
        $treatmentDTO->name = $newName;
        $treatmentDTO->money = $newMoney;
        $treatmentDTO->duration = $newDuration;
        $treatmentDTO->vat = $newVat;
        $treatment = $this->treatmentManager->update($treatmentDTO);

        $this->assertSame($treatment->getId(), $id);
        $this->assertSame($treatment->getName(), $newName);
        $this->assertSame($treatment->getMoney()->getValue(), $newMoney->getValue());
        $this->assertSame($treatment->getDuration(), $newDuration);
        $this->assertSame($treatment->getVat(), $newVat);
    }

    public function testDelete()
    {
        $this->expectException('Doctrine\ORM\NoResultException');
        $treatment = $this->entityManager->getRepository(Treatment::class)->find(1);
        $this->treatmentManager->delete($treatment);
        $this->entityManager->getRepository(Treatment::class)->find(1);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
