<?php

namespace Aop;

use Aop\Pointcut\Arguments;
use Aop\Aspect\Matcher\MatcherInterface;
use ReflectionClass;
use ReflectionMethod;
use InvalidArgumentException;

class Aspect
{
    protected $matchers = array();

    protected $beforePointcuts = array();
    protected $afterPointcuts = array();

    public function __construct()
    {
    }

    public function addMatcher(MatcherInterface $matcher)
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

    protected function getApplicableBeforePointcuts(ReflectionMethod $method)
    {
        return array_filter($this->beforePointcuts, function(Pointcut $p) use(&$method) {
            return $p->isApplicableFor($method);
        });
    }

    public function getApplicableBeforePointcutKeys(ReflectionMethod $method)
    {
        return array_flip(array_keys($this->getApplicableBeforePointcuts($method)));
    }

    protected function getApplicableAfterPointcuts(ReflectionMethod $method)
    {
        return array_filter($this->afterPointcuts, function(Pointcut $p) use(&$method) {
            return $p->isApplicableFor($method);
        });
    }

    public function getApplicableAfterPointcutKeys(ReflectionMethod $method)
    {
        return array_flip(array_keys($this->getApplicableAfterPointcuts($method)));
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
        if (isset($this->beforePointcuts[$pointcut->getHashCode()])) {
            throw new InvalidArgumentException('Pointcut already registered');
        }

        $pointcut->freeze();
        $this->beforePointcuts[$pointcut->getHashCode()] = $pointcut;
    }

    public function registerAfterPointcut(Pointcut $pointcut)
    {
        if (isset($this->afterPointcuts[$pointcut->getHashCode()])) {
            throw new InvalidArgumentException('Pointcut already registered');
        }

        $pointcut->freeze();
        $this->afterPointcuts[$pointcut->getHashCode()] = $pointcut;
    }
}