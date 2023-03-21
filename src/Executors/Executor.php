<?php

namespace SYSOTEL\OTA\Common\Executors;

abstract class Executor
{
    abstract public function handle();

    public static  function execute(...$args)
    {
        return (new static(...$args))->handle();
    }
}
