<?php

namespace App\DataFixtures;

use App\Service\MultitenantService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    function __construct(MultitenantService $multitenantService)
    {
        $multitenantService->setMultitenant(false);
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
