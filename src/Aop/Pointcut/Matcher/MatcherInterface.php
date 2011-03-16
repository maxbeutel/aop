<?php

namespace Aop\Pointcut\Matcher;

use Aop\Pointcut\Arguments;

interface MatcherInterface
{
    function match(Arguments $arguments);
}
