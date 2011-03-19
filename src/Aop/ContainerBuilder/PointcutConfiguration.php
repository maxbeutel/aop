<?php

namespace Aop\ContainerBuilder;

use Aop\Pointcut\Matcher\MethodName;
use InvalidArgumentException;

class PointcutConfiguration implements PointcutConfigurationInterface
{
    const POINTCUT_TYPE_BEFORE = 1;
    const POINTCUT_TYPE_AFTER = 2;

    protected $aspectConfiguration;
    protected $pointcutType;

    protected $callback;
    protected $matcher = array();

    public function __construct(AspectConfiguration $aspectConfiguration, $pointcutType)
    {
        $this->aspectConfiguration = $aspectConfiguration;
        $this->pointcutType = $pointcutType;
    }

    public function getMatcher()
    {
        return $this->matcher;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function methodName($methodName, $useRegex = false)
    {
        $this->matcher[] = new MethodName($methodName, $useRegex);
        return $this;
    }

    public function call($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid callback supplied');
        }

        $this->callback = $callback;
        return $this;
    }

    public function before()
    {
        return $this->aspectConfiguration->before();
    }

    public function after()
    {
        return $this->aspectConfiguration->after();
    }

    public function applyBefore()
    {
        return $this->pointcutType === self::POINTCUT_TYPE_BEFORE;
    }

    public function applyAfter()
    {
        return $this->pointcutType === self::POINTCUT_TYPE_AFTER;
    }
}




