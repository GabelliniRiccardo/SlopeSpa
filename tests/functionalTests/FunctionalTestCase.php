<?php


namespace App\Tests\functionalTests;


use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;
use DMore\ChromeDriver\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionalTestCase extends KernelTestCase
{
    /**
     * @var EntityManagerInterface|null
     */
    protected $entityManager;

    /**
     * This is static so we can access it inside the signal handler for interrupts.
     * @var ChromeDriver[]
     */
    private static $chromeDrivers = [];

    /**
     * @var Actor
     */
    protected $actor;

    /**
     * {@inheritdoc}
     * Boot the kernel and provide persistence capabilities to fixtures.
     */
    protected function setUp()
    {
        self::bootKernel();
        exec('bin/console doctrine:schema:drop -n -q --force --full-database --env=test');
        exec('bin/console doctrine:migrations:migrate -n -q --env=test');
        exec('bin/console doctrine:fixtures:load -n -q --env=test');
        $this->entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $this->actor = $this->createActor();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        // Avoid memory leaks due to the entity manager
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * Returns a test actor suitable for the tested application.
     * {@inheritdoc}
     *
     * @return Actor
     */
    protected function createActor()
    {
        return new Actor(
            $this->createChromeDriver(),
            $this->getContainer()
        );
    }

    /**
     * Creates a chrome driver instance with the provided base url.
     */
    protected function createChromeDriver(): ChromeDriver
    {
        $chromeDriver = new ChromeDriver(
            'http://chrome:5555',
            new HttpClient(),
            ''
        );
        self::$chromeDrivers[] = $chromeDriver;
        $chromeDriver->start();
        $chromeDriver->setSession(new Session($chromeDriver));
        return $chromeDriver;
    }

    /**
     * Returns the service container of the currently booted kernel.
     */
    protected function getContainer(): ContainerInterface
    {
        return self::$container;
    }
}
