<?php

namespace Aop;

use Aop\Pointcut\Callback;
use Aop\Pointcut\Arguments;
use Aop\Pointcut\Matcher\MatcherInterface;
use ReflectionMethod;
use BadMethodCallException;

class Pointcut
{
    protected $matchers = array();
    protected $callback;
    
    protected $hashCode;
    protected $frozen = false;

    public function __construct(Callback $callback)
    {
        $this->callback = $callback;
    }

    public function addMatcher(MatcherInterface $matcher)
    {
        if ($this->frozen) {
            throw new BadMethodCallException('Pointcut already frozen');
        }

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

    public function freeze()
    {
        $this->frozen = true;
    }

    public function getHashCode()
    {
        if ($this->hashCode === null) {
            $this->hashCode = md5(serialize($this));
        }

        return $this->hashCode;
    }
}





