<?php

namespace  Aop\Matcher;

class ClassMatcher
{
    private $pattern;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function match(\ReflectionClass $r)
    {

    }
}








