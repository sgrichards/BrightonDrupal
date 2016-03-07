<?php

namespace Todo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController
{
    public function taskAction(Request $request)
    {
        $id = $request->attributes->get('id');

        return new Response('Task #' . $id);
    }
}