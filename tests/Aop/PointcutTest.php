<?php

namespace Aop;

use PHPUnit_Framework_TestCase;

class PointcutTest extends PHPUnit_Framework_TestCase
{
    protected $callbackMock;
    protected $reflectionClassMock;
    protected $matcherMock;
    protected $argumentsMock;

    public function setUp()
    {
        $this->callbackMock = $this->getMock('Aop\Pointcut\Callback', array(), array(), '', false);
        $this->reflectionClassMock = $this->getMock('ReflectionClass', array(), array(), '', false);
        $this->matcherMock = $this->getMock('Aop\Pointcut\Matcher\MatcherInterface', array(), array(), '', false);
        $this->argumentsMock = $this->getMock('Aop\Pointcut\Arguments', array(), array(), '', false);
    }

    public function testExec()
    {
        $this->callbackMock->expects($this->once())->method('exec')->with($this->equalTo($this->argumentsMock));

        $pointcut = new Pointcut($this->callbackMock);
        $pointcut->exec($this->argumentsMock);
    }
}