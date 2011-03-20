<?php

namespace Aop\Pointcut;

use PHPUnit_Framework_Testcase;

class CallbackTest extends PHPUnit_Framework_Testcase
{
    protected $argumentsMock;
    
    protected static $staticClassMethodArguments;
    protected $instnaceMethodArguments;

    public static function staticMethodCallback()
    {
        self::$staticClassMethodArguments = func_get_args();
    }

    public function instanceMethodCallback()
    {
        $this->instnaceMethodArguments = func_get_args();
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

        $callback = new Callback(function() use(&$callbackArguments) {
            $callbackArguments = func_get_args();
        });

        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $callbackArguments[0]);
    }

    public function testExecStaticMethod()
    {
        $callback = new Callback(__CLASS__ . '::staticMethodCallback');
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, self::$staticClassMethodArguments[0]);
    }

    public function testExecInstanceMethod()
    {
        $callback = new Callback(array($this, 'instanceMethodCallback'));
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $this->instnaceMethodArguments[0]);
    }

    public function testExecClosureWithUserdefinedArguments()
    {
        $callbackArguments = null;

        $callback = new Callback(function() use(&$callbackArguments) {
            $callbackArguments = func_get_args();
        }, array('frob'));

        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $callbackArguments[0]);
        $this->assertEquals('frob', $callbackArguments[1]);
    }

    public function testExecStaticMethodWithUserdefinedArguments()
    {
        $callback = new Callback(__CLASS__ . '::staticMethodCallback', array('frob'));
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, self::$staticClassMethodArguments[0]);
        $this->assertEquals('frob', self::$staticClassMethodArguments[1]);
    }

    public function testExecInstanceMethodWithUserdefinedArguments()
    {
        $callback = new Callback(array($this, 'instanceMethodCallback'), array('frob'));
        $callback->exec($this->argumentsMock);

        $this->assertEquals($this->argumentsMock, $this->instnaceMethodArguments[0]);
        $this->assertEquals('frob', $this->instnaceMethodArguments[1]);
    }
}