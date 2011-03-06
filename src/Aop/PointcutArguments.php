<?php

namespace Aop;

class PointcutArguments
{
    private $weavedObject;
    private $method;
    private $interceptedParameters;

    public function __construct($weavedObject, $method, array $interceptedParameters)
    {
        $this->weavedObject = $weavedObject;
        $this->method = $method;
        $this->interceptedParameters = $interceptedParameters;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getInterceptedParameters()
    {
        return $this->interceptedParameters;
    }
}




