<?php

namespace Aop\Pointcut\Matcher;

use Aop\Pointcut\Arguments;

class MethodName implements MatcherInterface
{
    private $pattern;
    private $useRegex;

    public function __construct($pattern, $useRegex)
    {
        $this->pattern = $pattern;
        $this->useRegex = $useRegex;
    }

    public function match(Arguments $arguments)
    {
        if ($this->useRegex) {
            return (bool)preg_match('#' . $this->pattern . '#i', $arguments->getMethod());
        }

        return (bool)stristr($arguments->getMethodName(), $this->pattern);
    }
}








