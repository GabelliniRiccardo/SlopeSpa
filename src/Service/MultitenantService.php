<?php


namespace App\Service;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class MultitenantService implements EventSubscriberInterface
{
    private $multitenant;
    private $security;

    public function __construct(Security $security)
    {
        $this->multitenant = false;
        $this->security = $security;
    }

    /**
     * @param bool $multitenant
     */
    public function setMultitenant(bool $multitenant): void
    {
        $this->multitenant = $multitenant;
    }

    /**
     * @return bool
     */
    public function isMultitenant(): bool
    {
        return $this->multitenant;
    }

    /**
     * @return int
     */
    public function getSpaIdOfCurrentUser(): ?int
    {
        $user = $this->security->getUser();
        if ($user->getSpa()) {
            return $this->security->getUser()->getSpa()->getId();
        }
        return null;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['processMultitenant']
            ],
        ];
    }

    public function processMultitenant(GetResponseEvent $event)
    {
        if ($this->security->getUser()) {
            $roles = $this->security->getUser()->getRoles();
            if (in_array('ROLE_STAFF', $roles, true)) {
                $this->setMultitenant(true);
            } else {
                $this->setMultitenant(false);
            }
        }
    }
}
