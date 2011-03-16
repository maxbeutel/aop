<?php

namespace Aop\Aspect\Matcher;

require_once './src/Aop/Aspect/Matcher/MatcherInterface.php';
require_once './src/Aop/Aspect/Matcher/InterfaceImplementation.php';

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