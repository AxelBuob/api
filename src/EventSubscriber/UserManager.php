<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class UserManager implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    #[ArrayShape([KernelEvents::VIEW => 'array[]'])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['currentCustomerForUser', EventPriorities::POST_VALIDATE],
            ],
        ];
    }

    public function currentCustomerForUser(ViewEvent $viewEvent): void
    {
        $user = $viewEvent->getControllerResult();
        $method = $viewEvent->getRequest()->getMethod();

        if ($user instanceof User && Request::METHOD_POST === $method) {
            $user->setCustomer($this->security->getUser());
        }
    }
}
