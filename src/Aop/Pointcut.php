<?php

namespace Aop;

use Aop\Pointcut\Arguments;
use Aop\Pointcut\Callback;

class Pointcut
{
    protected $matchers = array();
    protected $callback;

    public function __construct(Callback $callback)
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
        $this->callback->exec($arguments);
    }
}





