<?php

namespace Aop;

class Aspect
{
    protected $container;
    protected $serviceId;

    protected $matchers = array();

    protected $beforePointcuts = array();
    protected $afterPointcuts = array();

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

    public function execBeforePointcuts(PointcutArguments $arguments)
    {
        array_map(function($p) use(&$arguments) {
            if ($p->isApplicableFor($arguments)) {
                $p->exec($arguments);
            }
        }, $this->beforePointcuts);
    }

    public function execAfterPointcuts(PointcutArguments $arguments)
    {
        array_map(function($p) use(&$arguments) {
            if ($p->isApplicableFor($arguments)) {
                $p->exec($arguments);
            }
        }, $this->afterPointcuts);
    }

    public function registerBeforePointcut(Pointcut $pointcut)
    {
        $this->beforePointcuts[] = $pointcut;
    }

    public function registerAfterPointcut(Pointcut $pointcut)
    {
        $this->afterPointcuts[] = $pointcut;
    }
}







