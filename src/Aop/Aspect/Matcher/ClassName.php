<?php

namespace Aop\Aspect\Matcher;

use ReflectionClass;

class ClassName implements MatcherInterface
{
    protected $pattern;
    protected $useRegex;

    public function __construct($pattern, $useRegex)
    {
        $this->pattern = $pattern;
        $this->useRegex = $useRegex;
    }

    public function match(ReflectionClass $r)
    {
        if ($this->useRegex) {
            return (bool)preg_match('#' . $this->pattern . '#i', $r->getName());
        }

        return (bool)stristr($r->getName(), $this->pattern);
    }
}








