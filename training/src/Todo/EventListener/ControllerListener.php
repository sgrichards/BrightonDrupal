<?php

namespace Todo\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Templating\EngineInterface;
use Todo\Controller\Controller;

class ControllerListener implements EventSubscriberInterface
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = current($event->getController());
        if ($controller instanceof Controller) {
            $controller->setTemplating($this->templating);
        }
    }
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController'
        );
    }
}