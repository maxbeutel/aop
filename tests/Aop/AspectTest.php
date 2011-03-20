<?php

namespace Aop;

use PHPUnit_Framework_Testcase;

class AspectTest extends PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->reflectionClassMock = $this->getMock('ReflectionClass', array(), array(), '', false);
    }

    public function testIsApplicableForReturnsFalseIfNoMatherExist()
    {
        $aspect = new Aspect();
        $this->assertFalse($aspect->isApplicableFor($this->reflectionClassMock));
    }
}