<?php

namespace Aop\Aspect\Matcher;

use PHPUnit_Framework_Testcase;
use ReflectionClass;

interface DummyInterface
{
}

class DummyClass implements DummyInterface
{
}

class InterfaceImplementationTest extends PHPUnit_Framework_Testcase
{
    public function testMatch()
    {
        $matcher = new InterfaceImplementation('Aop\Aspect\Matcher\DummyInterface');
        $r = new ReflectionClass('Aop\Aspect\Matcher\DummyClass');
        $this->assertTrue($matcher->match($r));
    }
    public function testDoNotMatch()
    {
        $matcher = new InterfaceImplementation('Aop\Aspect\Matcher\DummyInterface');
        $r = new ReflectionClass('stdClass');
        $this->assertFalse($matcher->match($r));
    }
}