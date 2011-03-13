<?php

namespace Aop\Pointcut;

use Aop\Pointcut\Arguments;

interface Matcher
{
    function match(Arguments $arguments);
}
