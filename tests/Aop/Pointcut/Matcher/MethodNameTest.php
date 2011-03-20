<?php

namespace Aop\Pointcut\Matcher;

use PHPUnit_Framework_Testcase;

class MethodNameTest extends PHPUnit_Framework_Testcase
{
    protected $reflectionMethodMock;

    public function setUp()
    {
        $this->reflectionMethodMock = $this->getMock('ReflectionMethod', array(), array(), '', false);
    }

    public function testMatchSimple()
    {
        $this->reflectionMethodMock->expects($this->any())->method('getName')->will($this->returnValue('someMethodName'));

        $matcher = new MethodName('Method', false);
        $this->assertTrue($matcher->match($this->reflectionMethodMock));
    }

    public function testDoNotMatchSimple()
    {
        $this->reflectionMethodMock->expects($this->any())->method('getName')->will($this->returnValue('someMethodName'));

        $matcher = new MethodName('XXX', false);
        $this->assertFalse($matcher->match($this->reflectionMethodMock));
    }

    public function testMatchRegex()
    {
        $this->reflectionMethodMock->expects($this->any())->method('getName')->will($this->returnValue('some_method_name'));

        $matcher = new MethodName('_([a-z]+)_', true);
        $this->assertTrue($matcher->match($this->reflectionMethodMock));
    }

    public function testDoNotMatchRegex()
    {
        $this->reflectionMethodMock->expects($this->any())->method('getName')->will($this->returnValue('some_method_name'));

        $matcher = new MethodName('_([0-9]+)_', true);
        $this->assertFalse($matcher->match($this->reflectionMethodMock));
    }
}