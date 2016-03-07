<?php

namespace Todo\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LegacyListener
{
    private $sourceDir;

    public function __construct($sourceDir)
    {
        $this->sourceDir = realpath($sourceDir);
    }

    private function runFile($file, Request $request) {
        ob_start();
        require $this->sourceDir . DIRECTORY_SEPARATOR . $file;

        return new Response(ob_get_clean());
    }

    function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();

        if ($file = $request->attributes->get('_file')) {
            $response = $this->runFile($file, $request);

            $event->setResponse($response);
        }
    }
}