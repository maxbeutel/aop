<?php

namespace Aop;

use Aop\Pointcut\Callback;
use Aop\Pointcut\Arguments;
use ReflectionMethod;

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

    public function isApplicableFor(ReflectionMethod $method)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($method)) {
                return true;
            }
        }

        return false;
    }

    public function exec(Arguments $arguments)
    {
        $this->callback->exec($arguments);
    }

    public function getHashCode()
    {
        // @TODO cache the hash
        return md5(serialize($this));
    }
}





