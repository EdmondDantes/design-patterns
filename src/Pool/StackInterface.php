<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface StackInterface
{
    public function pop(): object|null;
    
    public function push(object $object): void;
    
    public function getSize(): int;
    
    public function clear(): void;
}