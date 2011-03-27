<?php

namespace Aop\Proxy;

use Aop\Aspect;

class ProxyFactory
{
    public function __construct()
    {
    }

    public function getProxy(Aspect $aspect, \ReflectionClass $r)
    {
        $proxyClassName = str_replace('\\', '', $r->getName()) . 'Proxy';

        $proxyClassDefinition = str_replace(
            array(
                '<methods>',
                '<proxyClassName>',
                '<className>'
            ),
            array(
                $this->generateMethods($aspect, $r),
                $proxyClassName,
                $r->getName()
            ),
            self::$proxyTemplate
        );

        if (!class_exists($proxyClassName)) {
            eval($proxyClassDefinition);
        }

        $instance = new $proxyClassName();
        $instance->__setAspect($aspect);
        return $instance;
    }

    /**
     * Code from Doctrine Project
     *
     * @see https://github.com/doctrine/doctrine2/raw/master/lib/Doctrine/ORM/Proxy/ProxyFactory.php
     */
    private function generateMethods(Aspect $aspect, \ReflectionClass $r)
    {
        $methods = '';

        foreach ($r->getMethods() as $method) {
            /* @var $method ReflectionMethod */
            if ($method->isConstructor() || in_array(strtolower($method->getName()), array("__sleep", "__clone"))) {
                continue;
            }

            if ($method->isPublic() && ! $method->isFinal() && ! $method->isStatic()) {
                $methods .= PHP_EOL . '    public function ';
                if ($method->returnsReference()) {
                    $methods .= '&';
                }
                $methods .= $method->getName() . '(';
                $firstParam = true;
                $parameterString = $argumentString = '';

                $interceptedParameters = '';

                foreach ($method->getParameters() as $param) {
                    if ($firstParam) {
                        $firstParam = false;
                    } else {
                        $parameterString .= ', ';
                        $argumentString  .= ', ';
                    }

                    // We need to pick the type hint class too
                    if (($paramClass = $param->getClass()) !== null) {
                        $parameterString .= '\\' . $paramClass->getName() . ' ';
                    } else if ($param->isArray()) {
                        $parameterString .= 'array ';
                    }

                    if ($param->isPassedByReference()) {
                        $parameterString .= '&';
                    }

                    $parameterString .= '$' . $param->getName();
                    $argumentString  .= '$' . $param->getName();

                    if ($param->isDefaultValueAvailable()) {
                        $parameterString .= ' = ' . var_export($param->getDefaultValue(), true);
                    }

                    $interceptedParameters .= '"' . $param->getName() . '" => $' . $param->getName() . ',';
                }
                
                if ($interceptedParameters !== '') {
                    $interceptedParameters = 'array(' . $interceptedParameters . ')';
                } else {
                    $interceptedParameters = 'array()';
                }

                $methods .= $parameterString . ')';
                $methods .= PHP_EOL . '    {' . PHP_EOL;
                $methods .= PHP_EOL . '    $this->__aspect->execBeforePointcuts(' . var_export($aspect->getApplicableBeforePointcutKeys($method), true) . ', new \Aop\Pointcut\Arguments($this, __METHOD__, ' . $interceptedParameters . '));' . PHP_EOL;
                $methods .= '              parent::' . $method->getName() . '(' . $argumentString . ');';
                $methods .= PHP_EOL . '    $this->__aspect->execAfterPointcuts(' . var_export($aspect->getApplicableAfterPointcutKeys($method), true) . ', new \Aop\Pointcut\Arguments($this, __METHOD__, ' . $interceptedParameters . '));' . PHP_EOL;
                $methods .= PHP_EOL . '    }' . PHP_EOL;
            }
        }

        #print "<pre>";
        #print $methods;
        #print "</pre>";

        return $methods;
    }


    protected static $proxyTemplate = '
class <proxyClassName> extends \<className> implements \Aop\Proxy\Proxy
{
    private $__aspect;

    public function __construct()
    {
    }

    public function __setAspect(\Aop\Aspect $aspect)
    {
        $this->__aspect = $aspect;
    }

    <methods>
}
    ';
}







