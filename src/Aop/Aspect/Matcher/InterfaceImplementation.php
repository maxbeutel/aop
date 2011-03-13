<?php

namespace Aop\Aspect\Matcher;

use Aop\Aspect\Matcher;
use ReflectionClass;

class InterfaceImplementation implements Matcher
{
    protected $interfaceName;

    public function __construct($interfaceName)
    {
        $this->interfaceName = $interfaceName;
    }

    public function match(ReflectionClass $r)
    {
        return $r->implementsInterface($this->interfaceName);
    }
}






