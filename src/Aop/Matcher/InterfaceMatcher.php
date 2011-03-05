<?php

namespace Aop\Matcher;

class InterfaceMatcher
{
    private $interface;

    public function __construct($interface)
    {
        $this->interface = $interface;
    }

    public function match(\ReflectionClass $r)
    {
    }
}






