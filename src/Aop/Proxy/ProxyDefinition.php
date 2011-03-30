<?php

namespace Aop\Proxy;

use Aop\Aspect;
use ReflectionClass;

class ProxyDefinition
{
    protected $proxyClassName;
    protected $aspect;

    public function __construct($proxyClassName, Aspect $aspect)
    {
        $this->proxyClassName = $proxyClassName;
        $this->aspect = $aspect;
    }
    
    public function createInstance(array $constructorArguments)
    {
        $r = new ReflectionClass($this->proxyClassName);
        $proxyInstance = $r->getConstructor() === null ? $r->newInstance() : $r->newInstanceArgs($constructorArguments);
        $proxyInstance->__setAspect($this->aspect);
        return $proxyInstance;
    }
}