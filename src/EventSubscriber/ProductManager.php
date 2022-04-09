<?php
// api/src/EventSubscriber/ProductManager.php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ProductManager implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['checkProductAvailability', EventPriorities::PRE_READ],
        ];
    }
    

    public function checkProductAvailability(ViewEvent $event): void
    {
        $product = $event->getControllerResult();

        // dd($product);
        if (!$product) {
            throw new ProductNotFoundException(sprintf('The product "%s" does not exist.', $product->getId()));
            // Using internal codes for a better understanding of what's going on
        }
        
        if (!$product instanceof Product || !$event->getRequest()->isMethodSafe(false)) {
            return;
        }


    }
}
