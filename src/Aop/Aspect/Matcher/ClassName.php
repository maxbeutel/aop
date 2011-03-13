<?php

namespace Aop\Aspect\Matcher;

use ReflectionClass;

class ClassName
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
        return (bool)preg_match('#' . $this->pattern . '#i', $r->getName());
    }
}








