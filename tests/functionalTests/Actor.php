<?php


namespace App\Tests\functionalTests;


use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ExpectationException;
use DMore\ChromeDriver\ChromeDriver;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Psr\Container\ContainerInterface;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Actor
{
    /**
     * @var ChromeDriver
     */
    protected $chromeDriver;

    /**
     * @var string
     */
    protected $baseUrl = 'http://slopespa_app_1:81';

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(
        ChromeDriver $chromeDriver,
        ContainerInterface $container
    )
    {
        $this->chromeDriver = $chromeDriver;
        $this->container = $container;
    }

    /**
     * Returns the base url of the app
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Visit the url passed as param
     *
     */
    public function visit(string $url)
    {
        $this->chromeDriver->visit($this->baseUrl . $url);
    }

    /**
     * Returns the current url of the page
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->chromeDriver->getCurrentUrl();
    }

    /**
     * Return the status code of the request
     */
    public function getStatusCode()
    {
        return $this->chromeDriver->getStatusCode();
    }

    /**
     * Clicks on the element with the provided CSS selector.
     */
    public function clickOn(string $cssSelector): void
    {
        $this->retry(function () use ($cssSelector): void {
            $this->chromeDriver->click($this->translateCssToXPath($cssSelector));
        });
    }

    /**
     * Add text on input field
     */
    public function addTextOnInputField(string $cssSelector, string $text)
    {
        $this->retry(function () use ($cssSelector, $text): void {
            $this->chromeDriver->setValue($this->translateCssToXPath($cssSelector), $text);
        });
    }

    /**
     * Chooses an option from the provided select field.
     */
    public function selectOption(string $selectName, string $option): void
    {
        $this->retry(function () use ($selectName, $option): void {
            $this->chromeDriver->selectOption(
                $this->translateCssToXPath("select[name=\"$selectName\"],input[name=\"$selectName\"]"),
                $option
            );
        });
    }

    /**
     * Attempts to find an element by css selector, implicitly waiting for it.
     *
     * @throws ExpectationException
     */
    public function findOrFail(string $cssSelector): NodeElement
    {
        return $this->retry(function () use ($cssSelector) {
            $elements = $this->chromeDriver->find($this->translateCssToXPath($cssSelector));
            if (!$elements) {
                throw new ExpectationException(
                    "Could not find element with CSS selector $cssSelector",
                    $this->chromeDriver
                );
            }
            return $elements[0];
        });
    }

    /**
     * Asserts that the page which is currently visible contains the provided element.
     */
    public function shouldSeeElement(string $cssSelector): void
    {
        $this->retry(function () use ($cssSelector): void {
            if (!$this->chromeDriver->isVisible($this->translateCssToXPath($cssSelector))) {
                throw new ExpectationException(
                    "Element \"$cssSelector\" was not found in the current page.",
                    $this->chromeDriver
                );
            }
        });
    }

    /**
     * Asserts that the page which is currently visible does NOT contain the provided text.
     */
    public function shouldNotSee(string $text): void
    {
        $this->retry(function () use ($text): void {
            Assert::assertNotContains(
                $text,
                str_replace('&nbsp;', ' ', $this->chromeDriver->getContent()),
                "Text \"$text\" was still found in the body of the current page."
            );
        });
    }

    /**
     * Asserts that the page which is currently visible contains the provided text.
     */
    public function shouldSee(string $text): void
    {
        $this->retry(function () use ($text): void {
            Assert::assertContains(
                $text,
                str_replace('&nbsp;', ' ', $this->chromeDriver->getContent()),
                "Text \"$text\" was not found in the body of the current page."
            );
        });
    }

    /**
     * Translates CSS selector into XPath.
     *
     * @return string
     */
    public function translateCssToXPath(string $cssSelector): string
    {
        $converter = new CssSelectorConverter();
        return $converter->toXPath($cssSelector);
    }

    /**
     * Staff user is logged in
     */
    public function loginAsStaffUser()
    {
        $this->addTextOnInputField('[data-test="login-email"]', 'davidsenesi@gmail.com');
        $this->addTextOnInputField('[data-test="login-password"]', 'david');
        $this->clickOn('[data-test="login-button"]');
    }

    /**
     * Staff user is logged in
     */
    public function loginAsAdminUser()
    {
        $this->addTextOnInputField('[data-test="login-email"]', 'gabelliniriccardo.94@gmail.com');
        $this->addTextOnInputField('[data-test="login-password"]', 'riccard0');
        $this->clickOn('[data-test="login-button"]');
    }

    /**
     * Performs the provided action every 50ms up to a maximum of 100 retries (5 seconds), then fails.
     *
     * @return mixed
     */
    public function retry(\Closure $action)
    {
        $maxRetries = 100;
        $usInterval = 50000;
        $maxTime = $maxRetries * $usInterval;
        $startExecutionTime = microtime(true);
        for ($retry = 0; $retry <= $maxRetries; $retry++) {
            try {
                return $action();
            } catch (ExpectationException|ExpectationFailedException|DriverException $e) {
                if ($retry === $maxRetries || microtime(true) - $startExecutionTime > $maxTime) {
                    throw $e;
                }
                usleep($usInterval);
            }
        }
    }
}
