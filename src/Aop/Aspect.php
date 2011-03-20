<?php

namespace Aop;

use Aop\Pointcut\Arguments;
use ReflectionClass;

class Aspect
{
    protected $matchers = array();

    protected $beforePointcuts = array();
    protected $afterPointcuts = array();

    public function __construct()
    {
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
        array_map(function($p) use(&$arguments) {
            if ($p->isApplicableFor($arguments)) {
                $p->exec($arguments);
            }
        }, $this->beforePointcuts);
    }

    public function execAfterPointcuts(Arguments $arguments)
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







