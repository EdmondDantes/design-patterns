<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface PoolFactoryInterface
{
    public function createObject(): object;
    
    public function createUsageContext(object $object): UsageContextInterface;
}