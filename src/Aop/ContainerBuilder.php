<?php

namespace Aop;

use Aop\Proxy\ProxyFactory;
use Aop\Aspect\SelfRegistering;
use Symfony\Component\DependencyInjection\Definition;
use RuntimeException;
use ReflectionClass;

class ContainerBuilder extends \Symfony\Component\DependencyInjection\ContainerBuilder
{
    protected $aspects = array();

    protected $proxyFactory;

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
                    $proxy = $this->proxyFactory->getProxy($aspect, $r);
                    return $this->configureService($id, $definition, $proxy);
                    // @TODO: take constructor into consideration
                }
            }

            $service = null === $r->getConstructor() ? $r->newInstance() : $r->newInstanceArgs($arguments);
        }

        return $this->configureService($id, $definition, $service);
    }

    public function addAspect(SelfRegistering $aspect)
    {
        $aspect->register($this);
    }

    public function aspect(SelfRegistering $aspect)
    {
        
    }
}





