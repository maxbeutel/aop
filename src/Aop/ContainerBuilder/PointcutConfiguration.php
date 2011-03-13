<?php

namespace Aop\ContainerBuilder;

use Closure;

class PointcutConfiguration
{
    const POINTCUT_TYPE_BEFORE = 1;
    const POINTCUT_TYPE_AFTER = 2;

    protected $adviceConfiguration;
    protected $pointcutType;

    public function __construct($adviceConfiguration, $pointcutType)
    {
        $this->adviceConfiguration = $adviceConfiguration;
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
        return $this->adviceConfiguration->before();
    }

    public function after()
    {
        return $this->adviceConfiguration->after();
    }
}




