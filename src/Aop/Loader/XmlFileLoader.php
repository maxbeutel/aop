<?php

namespace Aop\Loader;

use Aop\Advice;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Symfony\Component\Config\Resource\FileResource;

class XmlFileLoader extends \Symfony\Component\DependencyInjection\Loader\XmlFileLoader
{
    /**
     * Loads an XML file.
     *
     * Basically calls parent::load() but also loads defined Aspects
     *
     * @param mixed  $resource The resource
     * @param string $type The resource type
     */
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);

        $xml = $this->parseFile($path);
        $xml->registerXPathNamespace('container', 'http://www.symfony-project.org/schema/dic/services');

        $this->container->addResource(new FileResource($path));

        // anonymous services
        $xml = $this->processAnonymousServices($xml, $file);

        // imports
        $this->parseImports($xml, $file);

        // parameters
        $this->parseParameters($xml, $file);

        // extensions
        $this->loadFromExtensions($xml);

        // interface injectors
        $this->parseInterfaceInjectors($xml, $file);

        // services
        $this->parseDefinitions($xml, $file);

        // aspects
        $this->parseAspects($xml, $file);
    }

    protected function parseAspects(SimpleXMLElement $xml, $file)
    {
        if (!$xml->aop) {
            return;
        }

        foreach ($xml->aop->aspect as $aspect) {
            $serviceId = (string) $aspect['service-id'];
            
            $advice = new Advice($this->container, $serviceId);

            foreach ($aspect->match->children() as $match) {
                $matcherClassName = '\Aop\Matcher\\' . ucfirst($match->getName()) . 'Matcher';
                // @TODO throw exception if matcher class not found
                // @TODO call constructor correctly, dont pass arguments array....
                $advice->addMatcher(new $matcherClassName($match->getArgumentsAsPhp('argument')));
            }

            $this->container->registerAdvice($advice);
        }
    }
}


