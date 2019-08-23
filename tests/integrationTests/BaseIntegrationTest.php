<?php


namespace App\Tests\integrationTests;


use App\Entity\User;
use App\Service\MultitenantService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class BaseIntegrationTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    protected $multitenantService;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        exec('bin/console doctrine:schema:drop -n -q --force --full-database --env=test');
        exec('bin/console doctrine:migrations:migrate -n -q --env=test');
        exec('bin/console doctrine:fixtures:load -n -q --env=test');
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->multitenantService = self::$container->get(MultitenantService::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**
     * Precondition: pre-authenticates the provided staff member.
     */
    protected function authenticateStaffMemberWithId(int $id): void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        self::$container->get('security.token_storage')
            ->setToken(new UsernamePasswordToken($user, '', 'secured_area', $user->getRoles()));
    }
}
