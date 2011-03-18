<?php

namespace Aop\ContainerBuilder;

use PHPUnit_Framework_Testcase;
use stdClass;

class AspectConfigurationTest extends PHPUnit_Framework_Testcase
{
    public function testSimpleGetter()
    {
        $service = new stdClass();
        $aspectConfiguration = new AspectConfiguration($service);

        $this->assertEquals($service, $aspectConfiguration->getService());
        $this->assertEquals($aspectConfiguration, $aspectConfiguration->weave());
        $this->assertEquals($aspectConfiguration, $aspectConfiguration->className('SomeClass'));
        $this->assertEquals($aspectConfiguration, $aspectConfiguration->interfaceImplementor('SomeInterface'));
    }

    public function testInterfaceImplementorCondition()
    {
        $service = new stdClass();
        $aspectConfiguration = new AspectConfiguration($service);
        $aspectConfiguration->interfaceImplementor('SomeInterface');

        list($matcher) = $aspectConfiguration->getMatcher();
        $this->assertType('Aop\Aspect\Matcher\InterfaceImplementation', $matcher);
    }

    public function testClassNameCondition()
    {
        $service = new stdClass();
        $aspectConfiguration = new AspectConfiguration($service);
        $aspectConfiguration->className('SomeClass');

        list($matcher) = $aspectConfiguration->getMatcher();
        $this->assertType('Aop\Aspect\Matcher\ClassName', $matcher);
    }

    public function testBeforePointcutConfiguration()
    {
        $service = new stdClass();
        $aspectConfiguration = new AspectConfiguration($service);
        $returnedPointcutConfiguration = $aspectConfiguration->before();

        list($pointcutConfiguration) = $aspectConfiguration->getPointcutConfigurations();
        $this->assertType('Aop\ContainerBuilder\PointcutConfiguration', $pointcutConfiguration);
        $this->assertTrue($pointcutConfiguration->applyBefore());
        $this->assertEquals($returnedPointcutConfiguration, $pointcutConfiguration);
    }

    public function testAfterPointcutConfiguration()
    {
        $service = new stdClass();
        $aspectConfiguration = new AspectConfiguration($service);
        $returnedPointcutConfiguration = $aspectConfiguration->after();

        list($pointcutConfiguration) = $aspectConfiguration->getPointcutConfigurations();
        $this->assertType('Aop\ContainerBuilder\PointcutConfiguration', $pointcutConfiguration);
        $this->assertTrue($pointcutConfiguration->applyAfter());
        $this->assertEquals($returnedPointcutConfiguration, $pointcutConfiguration);
    }
}