<?php

namespace Aop\Pointcut\Matcher;

use Aop\PointcutArguments;
use Aop\Pointcut\Matcher;

class MethodName implements Matcher
{
    private $pattern;
    private $useRegex;

    public function __construct($pattern, $useRegex)
    {
        $this->pattern = $pattern;
        $this->useRegex = $useRegex;
    }

    public function match(PointcutArguments $arguments)
    {
        if ($this->useRegex) {
            return (bool)preg_match('#' . $this->pattern . '#i', $arguments->getMethod());
        }

        return (bool)stristr($arguments->getMethod(), $this->pattern);
    }
}








