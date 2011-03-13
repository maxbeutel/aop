<?php

namespace Aop\ContainerBuilder;

use Aop\ContainerBuilder;

class AspectConfiguration
{
    protected $container;
    protected $aspect;

    protected $adviceConfiguration;

    public function __construct(ContainerBuilder $container, $aspect)
    {
        $this->container = $container;
        $this->aspect = $aspect;
    }

    public function weave()
    {
        $this->adviceConfiguration = new AdviceConfiguration($this);
        return $this->adviceConfiguration;
    }
}





