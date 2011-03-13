<?php

namespace Aop\Aspect;

use ReflectionClass;

interface Matcher
{
    function match(ReflectionClass $r);
}


