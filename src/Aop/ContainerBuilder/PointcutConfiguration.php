<?php

namespace Aop\ContainerBuilder;

use Closure;

class PointcutConfiguration
{
    const POINTCUT_TYPE_BEFORE = 1;
    const POINTCUT_TYPE_AFTER = 2;

    protected $aspectConfiguration;
    protected $pointcutType;

    public function __construct(AspectConfiguration $aspectConfiguration, $pointcutType)
    {
        $this->aspectConfiguration = $aspectConfiguration;
        $this->pointcutType = $pointcutType;
    }

    public function methodName($methodName, $useRegex = false)
    {
        return $this;
    }

    public function call($callback)
    {
        // $callback can be a method name or any of phps pseudo callback types
        return $this;
    }

    // Put in Interface
    public function before()
    {
        return $this->aspectConfiguration->before();
    }

    public function after()
    {
        return $this->aspectConfiguration->after();
    }
}




