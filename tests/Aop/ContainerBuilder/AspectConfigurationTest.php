<?php

namespace Aop\ContainerBuilder;

use PHPUnit_Framework_TestCase;
use stdClass;

class AspectConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleGetter()
    {
        $aspectConfiguration = new AspectConfiguration();

        $this->assertEquals($aspectConfiguration, $aspectConfiguration->className('SomeClass'));
        $this->assertEquals($aspectConfiguration, $aspectConfiguration->interfaceImplementor('SomeInterface'));
    }

    public function testInterfaceImplementorCondition()
    {
        $aspectConfiguration = new AspectConfiguration();
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
        $aspectConfiguration = new AspectConfiguration();
        $returnedPointcutConfiguration = $aspectConfiguration->before();

        list($pointcutConfiguration) = $aspectConfiguration->getPointcutConfigurations();
        $this->assertType('Aop\ContainerBuilder\PointcutConfiguration', $pointcutConfiguration);
        $this->assertTrue($pointcutConfiguration->applyBefore());
        $this->assertEquals($returnedPointcutConfiguration, $pointcutConfiguration);
    }

    public function testAfterPointcutConfiguration()
    {
        $aspectConfiguration = new AspectConfiguration();
        $returnedPointcutConfiguration = $aspectConfiguration->after();

        list($pointcutConfiguration) = $aspectConfiguration->getPointcutConfigurations();
        $this->assertType('Aop\ContainerBuilder\PointcutConfiguration', $pointcutConfiguration);
        $this->assertTrue($pointcutConfiguration->applyAfter());
        $this->assertEquals($returnedPointcutConfiguration, $pointcutConfiguration);
    }
}