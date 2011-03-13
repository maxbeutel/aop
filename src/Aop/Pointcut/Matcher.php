<?php

namespace Aop\Pointcut;

use Aop\PointcutArguments;

interface Matcher
{
    function match(PointcutArguments $arguments);
}
