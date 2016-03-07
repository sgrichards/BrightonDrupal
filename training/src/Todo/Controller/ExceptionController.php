<?php

namespace Todo\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController {
    public function exceptionAction(FlattenException $exception)
    {
        $code = $exception->getStatusCode();
        $text = isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] . var_export($exception,1) : '';

        return new Response($text, $code);
    }
}