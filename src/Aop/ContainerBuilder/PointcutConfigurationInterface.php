<?php

namespace Aop\ContainerBuilder;

interface PointcutConfigurationInterface
{
    function before();

    function after();
}