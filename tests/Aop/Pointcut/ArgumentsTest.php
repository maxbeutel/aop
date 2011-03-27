<?php

namespace Aop\Pointcut;

use PHPUnit_Framework_TestCase;

class ArgumentsTest extends PHPUnit_Framework_TestCase
{
    public function testGetter()
    {
        $arguments = new Arguments($this, __METHOD__, array());
        $this->assertEquals($this, $arguments->getWeavedObject());
        $this->assertEquals('testGetter', $arguments->getMethodName());
        $this->assertEquals('Aop\Pointcut\ArgumentsTest', $arguments->getClassName());
    }

    public function testGetInterceptedArgumentByName()
    {
        $arguments = new Arguments($this, __METHOD__, array('foo' => 'bar'));
        $this->assertEquals('bar', $arguments->getInterceptedArgument('foo'));
    }

    public function testGetInterceptedArgumentByNameThrowsExceptionIfNotFound()
    {
        $this->setExpectedException('InvalidArgumentException');

        $arguments = new Arguments($this, __METHOD__, array('foo' => 'bar'));
        $arguments->getInterceptedArgument('XXX');
    }

    public function testInterceptedArgumentIsSet()
    {
        $arguments = new Arguments($this, __METHOD__, array('foo' => 'bar'));
        $this->assertTrue($arguments->interceptedArgumentIsSet('foo'));
        $this->assertFalse($arguments->interceptedArgumentIsSet('XXX'));
    }
}