<?php

namespace Aop\Aspect\Matcher;

use ReflectionClass;

interface MatcherInterface
{
    function match(ReflectionClass $r);
}


