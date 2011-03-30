<?php

namespace Aop;

use Aop\Proxy\ProxyFactory;
use Aop\Aspect;
use Aop\Aspect\SelfRegistering;
use Aop\Pointcut;
use Aop\ContainerBuilder\AspectConfiguration;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder as BaseContainerBuilder;
use RuntimeException;
use ReflectionClass;

class ContainerBuilder extends BaseContainerBuilder
{
    protected $proxyFactory;

    protected $aspects = array();
    protected $aspectConfigurations = array();

    public function setProxyFactory(ProxyFactory $proxyFactory)
    {
        $this->proxyFactory = $proxyFactory;
    }

    protected function createService(Definition $definition, $id)
    {
        if (null !== $definition->getFile()) {
            require_once $this->getParameterBag()->resolveValue($definition->getFile());
        }

        $arguments = $this->resolveServices($this->getParameterBag()->resolveValue($definition->getArguments()));

        // no way to create a weaved object from a factory method :-(
        if (null !== $definition->getFactoryMethod()) {
            if (null !== $definition->getFactoryClass()) {
                $factory = $this->getParameterBag()->resolveValue($definition->getFactoryClass());
            } elseif (null !== $definition->getFactoryService()) {
                $factory = $this->get($this->getParameterBag()->resolveValue($definition->getFactoryService()));
            } else {
                throw new RuntimeException('Cannot create service from factory method without a factory service or factory class.');
            }

            $service = call_user_func_array(array($factory, $definition->getFactoryMethod()), $arguments);
        } else {
            $r = new ReflectionClass($this->getParameterBag()->resolveValue($definition->getClass()));

            // @TODO: currently only one aspect per class can be declared
            foreach ($this->aspects as $aspect) {
                if ($aspect->isApplicableFor($r)) {
                    $proxyDefinition = $this->proxyFactory->getProxyDefinition($aspect, $r);
                    return $this->configureService($id, $definition, $proxyDefinition->createInstance($arguments));
                }
            }

            $service = null === $r->getConstructor() ? $r->newInstance() : $r->newInstanceArgs($arguments);
        }

        return $this->configureService($id, $definition, $service);
    }

    public function addAspect(SelfRegistering $aspect)
    {
        $aspect->register($this);

        $aspectConfiguration = array_shift($this->aspectConfigurations);
        $this->addConfiguredAspect($aspectConfiguration);

        return $this;
    }

    public function weave()
    {
        $aspectConfiguration = new AspectConfiguration();
        $this->aspectConfigurations[] = $aspectConfiguration;
        return $aspectConfiguration;
    }

    protected function addConfiguredAspect(AspectConfiguration $aspectConfiguration)
    {
        $aspect = new Aspect();

        foreach ($aspectConfiguration->getMatcher() as $matcher) {
            $aspect->addMatcher($matcher);
        }

        foreach ($aspectConfiguration->getPointcutConfigurations() as $pointcutConfiguration) {
            $pointcut = new Pointcut($pointcutConfiguration->getCallback());

            foreach ($pointcutConfiguration->getMatcher() as $matcher) {
                $pointcut->addMatcher($matcher);
            }

            if ($pointcutConfiguration->applyBefore()) {
                $aspect->registerBeforePointcut($pointcut);
            }

            if ($pointcutConfiguration->applyAfter()) {
                $aspect->registerAfterPointcut($pointcut);
            }
        }

        $this->aspects[] = $aspect;
    }
}





