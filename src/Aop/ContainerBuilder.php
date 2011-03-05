<?php

namespace Aop;

use Symfony\Component\DependencyInjection\Definition;

class ContainerBuilder extends \Symfony\Component\DependencyInjection\ContainerBuilder
{
    protected $advices = array();

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
                throw new \RuntimeException('Cannot create service from factory method without a factory service or factory class.');
            }

            $service = call_user_func_array(array($factory, $definition->getFactoryMethod()), $arguments);
        } else {
            $r = new \ReflectionClass($this->getParameterBag()->resolveValue($definition->getClass()));

            foreach ($this->advices as $advice) {
                if ($advice->matches($r)) {
                    // @TODO
                }
            }

            $service = null === $r->getConstructor() ? $r->newInstance() : $r->newInstanceArgs($arguments);
        }

        return $this->configureService($id, $definition, $service);
    }

    public function registerAdvice(Advice $advice)
    {
        $this->advices[] = $advice;
    }
}





