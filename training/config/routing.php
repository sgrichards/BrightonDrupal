<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$route = new Route('/', array('_file' => 'list.php'));
$routes->add('legacy_homepage', $route);

$route = new Route('/list', array('_file' => 'list.php'));
$routes->add('legacy_list', $route);

$route = new Route('/todo', array('_file' => 'todo.php'));
$routes->add('legacy_show', $route);

return $routes;