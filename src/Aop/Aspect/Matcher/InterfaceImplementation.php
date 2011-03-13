<?php

namespace Aop\Aspect\Matcher;

use ReflectionClass;

class InterfaceImplementation
{
    private $interface;

    public function __construct($interface)
    {
        $this->interface = $interface;
    }

    public function match(ReflectionClass $r)
    {
        return $r->implementsInterface($this->interface);
    }
}






