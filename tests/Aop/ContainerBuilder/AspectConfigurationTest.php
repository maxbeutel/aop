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
}