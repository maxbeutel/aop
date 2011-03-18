<?php

namespace Aop\Pointcut\Matcher;

use PHPUnit_Framework_Testcase;
use Aop\Pointcut\Arguments;
use stdClass;

class MethodNameTest extends PHPUnit_Framework_Testcase
{
    public function testMatchSimple()
    {
        $arguments = new Arguments(new stdClass(), 'stdClass::foobar', array());

        $matcher = new MethodName('foo', false);
        $this->assertTrue($matcher->match($arguments));
    }

    public function testDoNotMatchSimple()
    {
        $arguments = new Arguments(new stdClass(), 'stdClass::foobar', array());

        $matcher = new MethodName('XXX', false);
        $this->assertFalse($matcher->match($arguments));
    }

    public function testMatchRegex()
    {
        $arguments = new Arguments(new stdClass(), 'stdClass::some_method_name', array());

        $matcher = new MethodName('_([a-z]+)_', true);
        $this->assertTrue($matcher->match($arguments));
    }

    public function testDoNotMatchRegex()
    {
        $arguments = new Arguments(new stdClass(), 'stdClass::some_method_name', array());

        $matcher = new MethodName('_([0-9]+)_', true);
        $this->assertFalse($matcher->match($arguments));
    }
}