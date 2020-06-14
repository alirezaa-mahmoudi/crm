<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\UpdatedAtDateEntityInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UpdatedAtEntitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['setUpdatedAt', EventPriorities::PRE_WRITE],
        ];
    }

    public function setUpdatedAt(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if (!$entity instanceof UpdatedAtDateEntityInterface || (Request::METHOD_POST !== $method && Request::METHOD_PUT !== $method)) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());
    }
}
