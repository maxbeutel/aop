<?php

namespace Aop\Proxy;

use Aop\Aspect;
use PHPUnit_Framework_TestCase;
use stdClass;

class ProxyStub_NoConstructor
{
    public $aspect;

    public function __setAspect(Aspect $aspect)
    {
        $this->aspect = $aspect;
    }
}

class ProxyStub_WithConstructor
{
    public $arg1;
    public $arg2;

    public $aspect;

    public function __construct(stdClass $arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }

    public function __setAspect(Aspect $aspect)
    {
        $this->aspect = $aspect;
    }
}

class ProxyDefinitionTest extends PHPUnit_Framework_TestCase
{
    protected $aspectMock;

    public function setUp()
    {
        $this->aspectMock = $this->getMock('Aop\Aspect', array(), array(), '', false);
    }

    public function testCreateInstance()
    {
        $proxyDefinition = new ProxyDefinition('Aop\Proxy\ProxyStub_NoConstructor', $this->aspectMock);
    }
}