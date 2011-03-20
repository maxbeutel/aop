<?php

namespace Aop\Pointcut\Matcher;

use ReflectionMethod;

interface MatcherInterface
{
    function match(ReflectionMethod $arguments);
}
