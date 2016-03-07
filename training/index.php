<?php

require_once 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @return Response
 */
function myWebsite(Request $request) {
  // Do something
  $name = $request->query->get('name');

  $session = new \Symfony\Component\HttpFoundation\Session\Session();
  $session->set('my_session', $session->get('my_session') + 1);

  $response = new Response('Hello ' . $name . ' - Session count: ' . $session->get('my_session'));
  $response->setStatusCode('404');

  return $response;
}

$request = Request::createFromGlobals();
$response = myWebsite($request);

$response->send();