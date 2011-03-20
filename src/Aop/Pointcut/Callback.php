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
        if ($this->phpCallback instanceof Closure) {
            $callback = $this->phpCallback;
            $callback($arguments);
        } else {
            call_user_func_array($this->phpCallback, array($arguments));
        }
    }
}