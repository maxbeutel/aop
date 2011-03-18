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
        
        $this->assertEquals(0, count($aspectConfiguration->getMatcher()));
        $aspectConfiguration->interfaceImplementor('SomeInterface');
        $this->assertEquals(1, count($aspectConfiguration->getMatcher()));
    }
}