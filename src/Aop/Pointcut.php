<?php

namespace Aop;

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

    public function isApplicableFor(PointcutArguments $arguments)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($arguments)) {
                return true;
            }
        }

        return false;
    }

    public function exec(Aspect $aspect, PointcutArguments $arguments)
    {
        $aspect->getService()->{$this->interceptorMethodName}($arguments);


        #print_r();
#
 #       print 'executing ' . __METHOD__;
    }
}





