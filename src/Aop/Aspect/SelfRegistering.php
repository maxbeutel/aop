<?php

namespace Aop\Aspect;

use Aop\ContainerBuilder;

interface SelfRegistering
{
    function register(ContainerBuilder $container);
}


