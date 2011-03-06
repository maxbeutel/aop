<?php

namespace Aop;

class Pointcut
{
    public function __construct()
    {
    }

    public function exec(PointcutArguments $arguments)
    {
        print 'executing ' . __METHOD__;
    }
}





