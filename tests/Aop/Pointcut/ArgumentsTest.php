<?php

namespace Aop\Pointcut;

use PHPUnit_Framework_Testcase;

class ArgumentsTest extends PHPUnit_Framework_Testcase
{
    public function testGetter()
    {
        $arguments = new Arguments($this, __METHOD__, array());
        $this->assertEquals($this, $arguments->getWeavedObject());
        $this->assertEquals('testGetter', $arguments->getMethodName());
        $this->assertEquals('Aop\Pointcut\ArgumentsTest', $arguments->getClassName());
    }
}