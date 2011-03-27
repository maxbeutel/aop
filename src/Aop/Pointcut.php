<?php

namespace Aop;

use Aop\Pointcut\Callback;
use Aop\Pointcut\Arguments;
use Aop\Pointcut\Matcher\MatcherInterface;
use ReflectionMethod;

class Pointcut
{
    protected $matchers = array();
    protected $callback;
    
    protected $hashCode;

    public function __construct(Callback $callback)
    {
        $this->callback = $callback;
    }

    public function addMatcher(MatcherInterface $matcher)
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
        if ($this->hashCode === null) {
            $this->hashCode = md5(serialize($this));
        }

        return $this->hashCode;
    }
}





