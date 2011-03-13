<?php

namespace Aop;

use Aop\Pointcut\Arguments;

class Pointcut
{
    protected $matchers = array();
    protected $interceptorMethodName;

    public function __construct($interceptorMethodName)
    {
        $this->interceptorMethodName = $interceptorMethodName;
    }

    public function addMatcher($matcher)
    {
        $this->matchers[] = $matcher;
    }

    public function isApplicableFor(Arguments $arguments)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($arguments)) {
                return true;
            }
        }

        return false;
    }

    // @TODO rather ugly, maybe give container service id to pointcut directly
    // acutally no need to go over aspect
    public function exec(Aspect $aspect, Arguments $arguments)
    {
        $aspect->getService()->{$this->interceptorMethodName}($arguments);
    }
}





