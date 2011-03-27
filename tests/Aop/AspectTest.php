<?php

namespace Aop;

use PHPUnit_Framework_TestCase;

class AspectTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->reflectionClassMock = $this->getMock('ReflectionClass', array(), array(), '', false);

        $this->beforePointcutMock_1 = $this->getMock('Aop\Pointcut', array(), array(), '', false);
        $this->beforePointcutMock_2 = $this->getMock('Aop\Pointcut', array(), array(), '', false);

        $this->afterPointcutMock_1 = $this->getMock('Aop\Pointcut', array(), array(), '', false);
        $this->afterPointcutMock_2 = $this->getMock('Aop\Pointcut', array(), array(), '', false);
    }

    public function testIsApplicableForReturnsFalseIfNoMatherExist()
    {
        $aspect = new Aspect();
        $this->assertFalse($aspect->isApplicableFor($this->reflectionClassMock));
    }

    public function testRegisteringPointcutFreezesPointcutInstance()
    {
        $aspect = new Aspect();
        $this->beforePointcutMock_1->expects($this->once())->method('freeze');
        $aspect->registerBeforePointcut($this->beforePointcutMock_1);
    }
}