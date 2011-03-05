<?php

namespace Aop;

class Advice
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
}







