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

    public function testDoesNotMatchSimple()
    {
        $arguments = new Arguments(new stdClass(), 'stdClass::foobar', array());

        $matcher = new MethodName('XXX', false);
        $this->assertFalse($matcher->match($arguments));
    }
}