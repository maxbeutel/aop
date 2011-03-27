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
        $this->afterPointcutMock_1->expects($this->once())->method('freeze');
        $aspect->registerAfterPointcut($this->afterPointcutMock_1);
    }

    public function testRegisterBeforePointcutThrowsExceptionIfAlreadyRegistered()
    {
        $this->beforePointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('123'));

        $aspect = new Aspect();
        $aspect->registerBeforePointcut($this->beforePointcutMock_1);

        $this->setExpectedException('InvalidArgumentException', 'Pointcut already registered');

        $aspect->registerBeforePointcut($this->beforePointcutMock_1);
    }

    public function testRegisterAfterPointcutThrowsExceptionIfAlreadyRegistered()
    {
        $this->afterPointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('123'));

        $aspect = new Aspect();
        $aspect->registerAfterPointcut($this->afterPointcutMock_1);

        $this->setExpectedException('InvalidArgumentException', 'Pointcut already registered');

        $aspect->registerAfterPointcut($this->afterPointcutMock_1);
    }
}