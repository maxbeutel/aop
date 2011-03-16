<?php

require_once realpath(__DIR__ . '/../symfony-src/src/Symfony/Component/ClassLoader/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => __DIR__ . '/../symfony-src/src',
    'Aop'     => __DIR__ . '/src',
));
$loader->register();



