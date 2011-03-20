<?php

namespace Aop\Pointcut\Matcher;

use ReflectionMethod;

class MethodName implements MatcherInterface
{
    private $pattern;
    private $useRegex;

    public function __construct($pattern, $useRegex)
    {
        $this->pattern = $pattern;
        $this->useRegex = $useRegex;
    }

    public function match(ReflectionMethod $method)
    {
        if ($this->useRegex) {
            return (bool)preg_match('#' . $this->pattern . '#i', $method->getName());
        }

        return (bool)stristr($method->getName(), $this->pattern);
    }
}








