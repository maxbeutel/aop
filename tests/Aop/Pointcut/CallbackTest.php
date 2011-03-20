<?php

namespace Aop\Pointcut;

use PHPUnit_Framework_Testcase;

class CallbackTest extends PHPUnit_Framework_Testcase
{
    protected $argumentsMock;
    
    protected static $staticClassMethodArguments;
    protected $instnaceMethodArguments;

    public static function staticMethodCallback(Arguments $arguments)
    {
        self::$staticClassMethodArguments = $arguments;
    }

    public function instanceMethodCallback(Arguments $arguments)
    {
        $this->instnaceMethodArguments = $arguments;
    }

    public function setUp()
    {
        $this->argumentsMock = $this->getMock('Aop\Pointcut\Arguments', array(), array(), '', false);
        
        self::$staticClassMethodArguments = null;
        $this->instnaceMethodArguments = null;
    }

    public function testExecClosure()
    {
        $callbackArguments = null;

        $callback = new Callback(function(Arguments $arguments) use(&$callbackArguments) {
            $callbackArguments = $arguments;
        });

        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $callbackArguments);
    }

    public function testExecStaticMethod()
    {
        $callback = new Callback(__CLASS__ . '::staticMethodCallback');
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, self::$staticClassMethodArguments);
    }

    public function testExecInstanceMethod()
    {
        $callback = new Callback(array($this, 'instanceMethodCallback'));
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $this->instnaceMethodArguments);
    }
}