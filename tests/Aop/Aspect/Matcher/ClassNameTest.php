<?php


namespace Aop\Aspect\Matcher;

require_once './src/Aop/Aspect/Matcher/MatcherInterface.php';
require_once './src/Aop/Aspect/Matcher/ClassName.php';


use PHPUnit_Framework_Testcase;
use ReflectionClass;

class ClassNameTest extends PHPUnit_Framework_TestCase
{
    public function testMatchSimple()
    {
        $matcher = new ClassName('std', false);
        $r = new ReflectionClass('stdClass');
        $this->assertTrue($matcher->match($r));

        $matcher = new ClassName('STD', false);
        $r = new ReflectionClass('stdClass');
        $this->assertTrue($matcher->match($r));
    }

    public function testDoNotMatchSimple()
    {
        $matcher = new ClassName('XYZ', false);
        $r = new ReflectionClass('stdClass');
        $this->assertFalse($matcher->match($r));
    }

    public function testMatchRegex()
    {
        $matcher = new ClassName('_([a-z]+)_', true);
        $r = new ReflectionClass('PHPUnit_Framework_TestCase');
        $this->assertTrue($matcher->match($r));

        $matcher = new ClassName('TestCase$', true);
        $r = new ReflectionClass('PHPUnit_Framework_TestCase');
        $this->assertTrue($matcher->match($r));
    }

    public function testDoNotMatchRegex()
    {
        $matcher = new ClassName('_([0-9]+)_', true);
        $r = new ReflectionClass('PHPUnit_Framework_TestCase');
        $this->assertFalse($matcher->match($r));
        
    }
}