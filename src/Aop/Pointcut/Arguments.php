<?php

namespace Aop\Pointcut;

class Arguments
{
    protected $weavedObject;
    protected $method;
    protected $interceptedParameters;

    public function __construct($weavedObject, $method, array $interceptedParameters)
    {
        $this->weavedObject = $weavedObject;
        $this->method = $method;
        $this->interceptedParameters = $interceptedParameters;
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
        return $this->interceptedParameters;
    }
}




