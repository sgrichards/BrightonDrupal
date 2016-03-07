<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$container->setParameter('kernel.root_dir', __DIR__);
$container->setParameter('kernel.config_dir', __DIR__.'/config');

$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('config/services.yml');

return $container;