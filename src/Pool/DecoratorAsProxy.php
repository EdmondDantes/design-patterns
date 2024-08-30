<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

use IfCastle\DI\DisposableInterface;

final class DecoratorAsProxy implements DecoratorInterface, DisposableInterface
{
    private \WeakReference|null $pool;
    
    public function __construct(private object|null $originalObject, PoolInterface $pool)
    {
        $this->pool                 = \WeakReference::create($pool);
    }
    
    public function __destruct()
    {
        $this->dispose();
    }
    
    #[\Override]
    public function getOriginalObject(): object
    {
        return $this->originalObject;
    }
    
    #[\Override]
    public function dispose(): void
    {
        $pool                       = $this->pool?->get();
        $originalObject             = $this->originalObject;
        $this->pool                 = null;
        $this->originalObject       = null;
        
        $pool?->return($originalObject);
    }
}