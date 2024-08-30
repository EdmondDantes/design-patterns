<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface PoolInterface
{
    public function borrow(): object|null;
    public function return(object $object): void;
    /**
     * Rebuild pool state and free unused objects.
     *
     * @return void
     */
    public function rebuild(): void;
    public function getMaxPoolSize(): int;
    public function getMinPoolSize(): int;
    public function getMaxWaitTimeout(): int;
    public function getUsed(): int;
    public function getPoolSize(): int;
}