<?php

namespace IfCastle\DesignPatterns\Pool;

/**
 * # Return Factory Interface
 *
 * A return factory is responsible for creating decorators for objects in the pool.
 *
 * The decorator object wraps the original object with the purpose of automatically returning it to the Pool
 * when the destructor is called or explicitly through the dispose() method.
 *
 */
interface ReturnFactoryInterface
{
    public function createDecorator(object $originalObject, PoolInterface $pool): object;
}