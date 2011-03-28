<?php

namespace Aop;

use PHPUnit_Framework_TestCase;

class AspectTest extends PHPUnit_Framework_TestCase
{
    protected $reflectionClassMock;
    protected $reflectionMethodMock;

    protected $beforePointcutMock_1;
    protected $beforePointcutMock_2;

    protected $afterPointcutMock_1;
    protected $afterPointcutMock_2;

    protected $argumentsMock;

    protected $matcherMock;

    public function setUp()
    {
        $this->reflectionClassMock = $this->getMock('ReflectionClass', array(), array(), '', false);
        $this->reflectionMethodMock = $this->getMock('ReflectionMethod', array(), array(), '', false);

        $this->beforePointcutMock_1 = $this->getMock('Aop\Pointcut', array(), array(), '', false);
        $this->beforePointcutMock_2 = $this->getMock('Aop\Pointcut', array(), array(), '', false);

        $this->afterPointcutMock_1 = $this->getMock('Aop\Pointcut', array(), array(), '', false);
        $this->afterPointcutMock_2 = $this->getMock('Aop\Pointcut', array(), array(), '', false);

        $this->argumentsMock = $this->getMock('Aop\Pointcut\Arguments', array(), array(), '', false);

        $this->matcherMock = $this->getMock('Aop\Aspect\Matcher\MatcherInterface', array(), array(), '', false);
    }

    public function testIsApplicableForReturnsFalseIfNoMatcherExist()
    {
        $aspect = new Aspect();
        $this->assertFalse($aspect->isApplicableFor($this->reflectionClassMock));
    }

    public function testGetApplicableBeforePointcutKeys()
    {
        $this->beforePointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('1234'));
        $this->beforePointcutMock_1->expects($this->any())->method('isApplicableFor')->with($this->equalTo($this->reflectionMethodMock))->will($this->returnValue(true));

        $this->beforePointcutMock_2->expects($this->any())->method('getHashCode')->will($this->returnValue('5678'));
        $this->beforePointcutMock_2->expects($this->any())->method('isApplicableFor')->with($this->equalTo($this->reflectionMethodMock))->will($this->returnValue(false));

        $aspect = new Aspect();
        $this->assertEquals(array(), $aspect->getApplicableBeforePointcutKeys($this->reflectionMethodMock));

        $aspect = new Aspect();
        $aspect->registerBeforePointcut($this->beforePointcutMock_1);
        $aspect->registerBeforePointcut($this->beforePointcutMock_2);
        $this->assertEquals(array('1234' => 0), $aspect->getApplicableBeforePointcutKeys($this->reflectionMethodMock));
    }


    public function testGetApplicableAfterPointcutKeys()
    {
        $this->afterPointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('1234'));
        $this->afterPointcutMock_1->expects($this->any())->method('isApplicableFor')->with($this->equalTo($this->reflectionMethodMock))->will($this->returnValue(true));

        $this->afterPointcutMock_2->expects($this->any())->method('getHashCode')->will($this->returnValue('5678'));
        $this->afterPointcutMock_2->expects($this->any())->method('isApplicableFor')->with($this->equalTo($this->reflectionMethodMock))->will($this->returnValue(false));

        $aspect = new Aspect();
        $this->assertEquals(array(), $aspect->getApplicableAfterPointcutKeys($this->reflectionMethodMock));

        $aspect = new Aspect();
        $aspect->registerAfterPointcut($this->afterPointcutMock_1);
        $aspect->registerAfterPointcut($this->afterPointcutMock_2);
        $this->assertEquals(array('1234' => 0), $aspect->getApplicableAfterPointcutKeys($this->reflectionMethodMock));
    }

    public function testIsAppicableForReturnsFalseIfMatcherDoesnotMatch()
    {
        $this->matcherMock->expects($this->any())->method('match')->with($this->equalTo($this->reflectionClassMock))->will($this->returnValue(false));

        $aspect = new Aspect();
        $aspect->addMatcher($this->matcherMock);
        $this->assertFalse($aspect->isApplicableFor($this->reflectionClassMock));
    }

    public function testIsAppicableForReturnsTrueIfMatcherMatches()
    {
        $this->matcherMock->expects($this->any())->method('match')->with($this->equalTo($this->reflectionClassMock))->will($this->returnValue(true));

        $aspect = new Aspect();
        $aspect->addMatcher($this->matcherMock);
        $this->assertTrue($aspect->isApplicableFor($this->reflectionClassMock));
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

    public function testRegisterAndExecBeforePointcut()
    {
        $this->beforePointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('123'));
        $this->beforePointcutMock_1->expects($this->once())->method('exec');

        $aspect = new Aspect();
        $aspect->registerBeforePointcut($this->beforePointcutMock_1);
        $aspect->execBeforePointcuts(array('123' => 0), $this->argumentsMock);
    }

    public function testRegisterAndExecAfterPointcut()
    {
        $this->afterPointcutMock_1->expects($this->any())->method('getHashCode')->will($this->returnValue('123'));
        $this->afterPointcutMock_1->expects($this->once())->method('exec');

        $aspect = new Aspect();
        $aspect->registerAfterPointcut($this->afterPointcutMock_1);
        $aspect->execAfterPointcuts(array('123' => 0), $this->argumentsMock);
    }
}