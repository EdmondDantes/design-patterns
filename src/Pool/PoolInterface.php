<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

/**
 * # Pool Interface
 *
 * A pool is a collection of objects that can be borrowed and returned.
 */
interface PoolInterface
{
    /**
     * Borrow an object from the pool.
     *
     * @return object|null
     */
    public function borrow(): object|null;
    
    /**
     * Return an object to the pool.
     *
     * @param object $object
     * @return void
     */
    public function return(object $object): void;
    
    /**
     * Rebuild pool state and free unused objects.
     *
     * @return void
     */
    public function rebuild(): void;
    
    /**
     * Get the maximum pool size.
     *
     * @return int
     */
    public function getMaxPoolSize(): int;
    
    /**
     * Get the minimum pool size.
     *
     * @return int
     */
    public function getMinPoolSize(): int;
    
    /**
     * Get the timeout for borrowing an object.
     *
     * @return int
     */
    public function getMaxWaitTimeout(): int;
    
    /**
     * Get used objects count.
     *
     * @return int
     */
    public function getUsed(): int;
    
    /**
     * Get the pool size.
     *
     * @return int
     */
    public function getPoolSize(): int;
}