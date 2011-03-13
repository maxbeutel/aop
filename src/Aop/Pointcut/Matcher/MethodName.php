<?php

namespace Aop\Pointcut\Matcher;

use Aop\PointcutArguments;

class MethodName
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
        return (bool) preg_match('#' . $this->pattern . '#i', $arguments->getMethod());
    }
}








