<?php

namespace Aop\Pointcut;

use InvalidArgumentException;

class Arguments
{
    protected $weavedObject;
    protected $method;
    protected $interceptedArguments;

    public function __construct($weavedObject, $method, array $interceptedArguments)
    {
        $this->weavedObject = $weavedObject;
        $this->method = $method;
        $this->interceptedArguments = $interceptedArguments;
    }

    public function getWeavedObject()
    {
        return $this->weavedObject;
    }

    public function getMethodName()
    {
        list($className, $methodName) = explode('::', $this->method);
        return $methodName;
    }

    public function getClassName()
    {
        list($className, $methodName) = explode('::', $this->method);
        return $className;
    }

    public function getInterceptedParameters()
    {
        return $this->interceptedArguments;
    }

    public function getInterceptedArgument($name)
    {
        if (!$this->interceptedArgumentIsSet($name)) {
            throw new InvalidArgumentException('Argument by name ' . $name . ' not found');
        }

        return $this->interceptedArguments[$name];
    }

    public function interceptedArgumentIsSet($name)
    {
        return isset($this->interceptedArguments[$name]);
    }
}




