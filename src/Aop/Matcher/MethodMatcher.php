<?php

namespace Aop\Matcher;

use Aop\PointcutArguments;

/**
 * @TODO this is a pointcut matcher, move to own namespace!
 */
class MethodMatcher
{
    private $pattern;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function match(PointcutArguments $arguments)
    {
        return (bool) preg_match('#' . $this->pattern . '#i', $arguments->getMethod());
    }
}








