<?php

namespace Aop\ContainerBuilder;

use PHPUnit_Framework_TestCase;

class PointcutConfigurationTest extends PHPUnit_Framework_TestCase
{
    protected $aspectConfigurationMock;

    public function setUp()
    {
        $this->aspectConfigurationMock = $this->getMock('Aop\ContainerBuilder\AspectConfiguration', array(), array(), '', false);
    }

    public function testTypeGetter()
    {
        $pointcutConfiguration = new PointcutConfiguration($this->aspectConfigurationMock, PointcutConfiguration::POINTCUT_TYPE_BEFORE);
        $this->assertTrue($pointcutConfiguration->applyBefore());

        $pointcutConfiguration = new PointcutConfiguration($this->aspectConfigurationMock, PointcutConfiguration::POINTCUT_TYPE_AFTER);
        $this->assertTrue($pointcutConfiguration->applyAfter());
    }

    public function testSimpleGetter()
    {
        $pointcutConfiguration = new PointcutConfiguration($this->aspectConfigurationMock, PointcutConfiguration::POINTCUT_TYPE_BEFORE);
        $pointcutConfiguration->call('strtolower');
        $this->assertType('Aop\Pointcut\Callback', $pointcutConfiguration->getCallback());
    }

    public function testCallThrowsExceptionOnInvalidCallback()
    {
        $this->setExpectedException('InvalidArgumentException');

        $pointcutConfiguration = new PointcutConfiguration($this->aspectConfigurationMock, PointcutConfiguration::POINTCUT_TYPE_BEFORE);
        $pointcutConfiguration->call('nonExistingMethod');
    }
    
    public function testCallAcceptsClosures()
    {
        $pointcutConfiguration = new PointcutConfiguration($this->aspectConfigurationMock, PointcutConfiguration::POINTCUT_TYPE_BEFORE);
        $pointcutConfiguration->call(function() { });
    }
}