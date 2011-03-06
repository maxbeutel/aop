<?php

require_once __DIR__.'/../../symfony-src/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\FileLocator;

interface ControllerInterface
{

}

class MyControllerClass implements ControllerInterface
{
    public function doStuffAction($someValue, $someOtherValue)
    {
        print "doStuffAction called";
    }
}

class ControllerAspect
{
    public function beforeControllerAction()
    {
        print 'beforeControllerAction';
    }

    public function afterControllerAction()
    {
        print 'afterControllerAction';
    }
}



$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => __DIR__.'/../../symfony-src/src',
    'Aop'     => __DIR__.'/../src',
));
$loader->register();


$container = new Aop\ContainerBuilder();
$container->setProxyFactory(new Aop\Proxy\ProxyFactory());
$loader = new Aop\Loader\XmlFileLoader($container, new FileLocator('./_exploring'));
$loader->load('sample.xml');



$controller = $container->get('MyControllerClass');
$controller->doStuffAction('xy', 13);


#$loader = new XmlFileLoader($container, new FileLocator('./_exploring'));




