<?php

namespace Aop\ContainerBuilder;

use Aop\Aspect\Matcher\ClassName;
use Aop\Aspect\Matcher\InterfaceImplementation;

class AspectConfiguration
{
    protected $service;

    protected $pointcutConfigurations = array();
    protected $matcher = array();


    // @TODO service might also be a callback instead of class instance
    public function __construct($service)
    {
        $this->service = $service;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getMatcher()
    {
        return $this->matcher;
    }

    public function getPointcutConfigurations()
    {
        return $this->pointcutConfigurations;
    }

    public function weave()
    {
        return $this;
    }

    public function className($className, $useRegex = false)
    {
        $this->matcher[] = new ClassName($className, $useRegex);
        return $this;
    }

    public function interfaceImplementor($interfaceName)
    {
        $this->matcher[] = new InterfaceImplementation($interfaceName);
        return $this;
    }

    public function before()
    {
        $pointcutConfiguration = new PointcutConfiguration($this, PointcutConfiguration::POINTCUT_TYPE_BEFORE);
        $this->pointcutConfigurations[] = $pointcutConfiguration;
        return $pointcutConfiguration;
    }

    public function after()
    {
        $pointcutConfiguration = new PointcutConfiguration($this, PointcutConfiguration::POINTCUT_TYPE_AFTER);
        $this->pointcutConfigurations[] = $pointcutConfiguration;
        return $pointcutConfiguration;
    }
}




