<?php

namespace Aop;

use Aop\Pointcut\Arguments;
use ReflectionClass;

class Aspect
{
    protected $container;
    protected $service;

    protected $matchers = array();

    protected $beforePointcuts = array();
    protected $afterPointcuts = array();

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function getService()
    {
        return $this->service;
    }

    public function addMatcher($matcher)
    {
        $this->matchers[] = $matcher;
    }

    public function isApplicableFor(ReflectionClass $r)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->match($r)) {
                return true;
            }
        }

        return false;
    }

    public function execBeforePointcuts(Arguments $arguments)
    {
        $aspect = $this;

        array_map(function($p) use(&$aspect, &$arguments) {
            if ($p->isApplicableFor($arguments)) {
                $p->exec($aspect, $arguments);
            }
        }, $this->beforePointcuts);
    }

    public function execAfterPointcuts(Arguments $arguments)
    {
        $aspect = $this;

        array_map(function($p) use(&$aspect, &$arguments) {
            if ($p->isApplicableFor($arguments)) {
                $p->exec($aspect, $arguments);
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







