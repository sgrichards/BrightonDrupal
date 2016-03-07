<?php

namespace Todo\Controller;

use Symfony\Component\Templating\EngineInterface;

abstract class Controller
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    public function setTemplating(EngineInterface $templating) {
        $this->templating = $templating;
    }
}