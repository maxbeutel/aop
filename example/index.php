<?php

require_once realpath(__DIR__ . '/../autoload.php');

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
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

class ControllerAspect implements Aop\Aspect\SelfRegistering
{
    public function beforeControllerAction()
    {
        print 'beforeControllerAction';
    }

    public function afterControllerAction()
    {
        print 'afterControllerAction';
    }

    public function register(Aop\ContainerBuilder $container)
    {
        $container->aspect($this)->weave()->className('Controller')
                  ->before()->methodName('Action')->call('beforeControllerAction')
                  ->after()->methodName('Action')->call('afterControllerAction');
    }
}




// Create Builder
$container = new Aop\ContainerBuilder();
$container->setProxyFactory(new Aop\Proxy\ProxyFactory());
$loader = new XmlFileLoader($container, new FileLocator('./_exploring'));
$loader->load('sample.xml');


// register Aspects
$container->addAspect(new ControllerAspect());


// Test get controller instance from container
$controller = $container->get('MyControllerClass');
$controller->doStuffAction('xy', 13);







