<?php

namespace IfCastle\DesignPatterns\Pool;

final class Stack                   implements StackInterface
{
    private array $stack             = [];
    
    #[\Override]
    public function pop(): object|null
    {
        return array_pop($this->stack);
    }
    
    #[\Override]
    public function push(object $object): void
    {
        $this->stack[]              = $object;
    }
    
    #[\Override]
    public function getSize(): int
    {
        return count($this->stack);
    }
    
    #[\Override]
    public function clear(): void
    {
        $this->stack                = [];
    }
}