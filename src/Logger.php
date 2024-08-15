<?php

namespace Drewlabs\Laravel\Memory\Usage;

final class Logger
{

    /**
     * Decorate a function that track a function memory usage.
     * `$handler` when provided takes as argument a log object that 
     * contains information about memory usage (used system memory and requested system memory)
     * the function being invoked.
     * 
     * @psalm-template T
     * @template T
     * 
     * @param string $name 
     * @param callable $handler 
     * @return \Closure(\Clouse(...$args): T): T 
     */
    public static function create(string $name, callable $handler)
    {
        return function (callable $callback) use ($name, $handler) {
            # Query for allocated memory before
            $allocation = new AllocatedMemory(memory_get_usage(), memory_get_usage(true));

            # Handle the request by the matching controller
            $result = $callback();

            # Query for allocated memory after laravel handles request
            $allocation2 = new AllocatedMemory(memory_get_usage(), memory_get_usage(true));

            call_user_func($handler, new Log($name, $allocation, $allocation2, time()));

            return $result;
        };
    }
}
