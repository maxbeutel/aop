<?php

namespace Aop;

use Aop\Pointcut\Arguments;

class Pointcut
{
    protected $matchers = array();
    protected $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
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

    public function exec(Arguments $arguments)
    {
        // @TODO execute callback   
        #$aspect->getService()->{$this->interceptorMethodName}($arguments);
    }
}





