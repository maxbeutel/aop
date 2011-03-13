<?php

namespace Aop\ContainerBuilder;

use Closure;

class PointcutConfiguration
{
    protected $adviceConfiguration;

    public function __construct($adviceConfiguration)
    {
        $this->adviceConfiguration = $adviceConfiguration;
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




