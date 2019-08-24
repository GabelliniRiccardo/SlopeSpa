<?php

namespace App\Tests\integrationTests\ManagerTests;

use App\Entity\SPA;
use App\Tests\integrationTests\BaseIntegrationTest;

class MultitenantTest extends BaseIntegrationTest
{
    private $spaRepository;

    public function setUp()
    {
        parent::setUp();
        $this->spaRepository = $this->entityManager->getRepository(SPA::class);
    }

    public function testForStaffUser()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $spaList = $this->spaRepository->findAll();
        $this->assertSame(sizeof($spaList), 1);
    }

    public function testForAdminUser()
    {
        $this->multitenantService->setMultitenant(false);
        $spaList = $this->spaRepository->findAll();
        $this->assertSame(sizeof($spaList), 2);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
