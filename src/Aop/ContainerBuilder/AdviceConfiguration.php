<?php

namespace Aop\ContainerBuilder;

class AdviceConfiguration
{
    protected $aspectConfiguration;

    protected $pointcutConfigurations = array();

    public function __construct(AspectConfiguration $aspectConfiguration)
    {
        $this->aspectConfiguration = $aspectConfiguration;
    }

    public function className($className, $useRegex = false)
    {
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






