<?php

namespace App\Tests\integrationTests\RepositoryTests;

use App\Entity\SPA;
use App\Tests\integrationTests\BaseIntegrationTest;

class SpaRepositoryTest extends BaseIntegrationTest
{
    private $spaRepository;

    public function setUp()
    {
        parent::setUp();
        $this->spaRepository = $this->entityManager->getRepository(SPA::class);
    }

    public function testFindAllWithouthTenancy()
    {
        $this->multitenantService->setMultitenant(false);
        $spaList = $this->spaRepository->findAll();
        $this->assertSame(sizeof($spaList), 2);
    }

    public function testFindAllWithTenancy()
    {
        $this->authenticateStaffMemberWithId(3);
        $this->multitenantService->setMultitenant(true);
        $spaList = $this->spaRepository->findAll();
        $this->assertSame(sizeof($spaList), 1);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
