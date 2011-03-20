<?php

namespace Aop\Pointcut;

use Closure;

class Callback
{
    protected $phpCallback;
    protected $userDefinedArguments;

    public function __construct($phpCallback, array $userDefinedArguments = array())
    {
        $this->phpCallback = $phpCallback;
        $this->userDefinedArguments = $userDefinedArguments;
    }

    public function exec(Arguments $arguments)
    {
        call_user_func_array($this->phpCallback, array_merge(array($arguments), $this->userDefinedArguments));
    }
}