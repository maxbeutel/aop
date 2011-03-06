<?php

namespace Aop;

class Pointcut
{
    protected $matchers = array();

    public function __construct()
    {
    }

    public function addMatcher($matcher)
    {
        $this->matchers[] = $matcher;
    }

    public function isApplicableFor(PointcutArguments $arguments)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($arguments)) {
                return true;
            }
        }

        return false;
    }

    public function exec(PointcutArguments $arguments)
    {
        print 'executing ' . __METHOD__;
    }
}





