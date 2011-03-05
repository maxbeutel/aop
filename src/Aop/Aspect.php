<?php

namespace Aop;

class Aspect
{
    protected $container;
    protected $serviceId;

    protected $matchers = array();

    public function __construct($container, $serviceId)
    {
        $this->container = $container;
        $this->serviceId = $serviceId;
    }

    public function addMatcher($matcher)
    {
        $this->matchers[] = $matcher;
    }

    public function isApplicableFor(\ReflectionClass $r)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($r)) {
                return true;
            }
        }

        return false;
    }
}







