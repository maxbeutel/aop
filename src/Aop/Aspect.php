<?php

namespace Aop;

use Aop\Pointcut\Arguments;
use ReflectionClass;
use ReflectionMethod;

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

    public function getApplicableBeforePointcuts(ReflectionMethod $method)
    {
        return array_filter($this->beforePointcuts, function(Pointcut $p) use(&$method) {
            return $p->isApplicableFor($method);
        });
    }

    public function getApplicableAfterPointcuts(ReflectionMethod $method)
    {
        return array_filter($this->afterPointcuts, function(Pointcut $p) use(&$method) {
            return $p->isApplicableFor($method);
        });
    }

    public function execBeforePointcuts(array $pointcutHashCodes, Arguments $arguments)
    {
        $applicablePointcuts = array_intersect_key($this->beforePointcuts, $pointcutHashCodes);

        array_map(function(Pointcut $p) use(&$arguments) {
            $p->exec($arguments);
        }, $applicablePointcuts);
    }

    public function execAfterPointcuts(array $pointcutHashCodes, Arguments $arguments)
    {
        $applicablePointcuts = array_intersect_key($this->afterPointcuts, $pointcutHashCodes);

        array_map(function(Pointcut $p) use(&$arguments) {
            $p->exec($arguments);
        }, $applicablePointcuts);
    }

    public function registerBeforePointcut(Pointcut $pointcut)
    {
        // @TODO: freeze pointcut
        // @TODO: throw exception if pointcut with same hashcode alrady existis
        // @TODO: Maybe check Pointcut type?
        $this->beforePointcuts[$pointcut->getHashCode()] = $pointcut;
    }

    public function registerAfterPointcut(Pointcut $pointcut)
    {
        // @TODO: freeze pointcut
        // @TODO: throw exception if pointcut with same hashcode alrady existis
        // @TODO: Maybe check Pointcut type?
        $this->afterPointcuts[$pointcut->getHashCode()] = $pointcut;
    }
}