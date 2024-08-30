<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

use IfCastle\DI\DisposableInterface;

class Pool                          implements PoolInterface
{
    private array $borrowed         = [];
    private int   $lastBorrowAt     = 0;
    
    public function __construct(
        protected StackInterface   $pool,
        protected FactoryInterface $factory,
        protected int              $maxPoolSize,
        protected int              $minPoolSize = 0,
        protected int              $timeout           = -1,
        protected int              $delayPoolReduction = 0
    ) {}
    
    protected function init(): void
    {
        for($i = 0; $i < $this->minPoolSize; $i++) {
            $this->pool->push($this->factory->createObject());
        }
    }
    
    public function borrow(): object|null
    {
        if(count($this->borrowed) >= $this->maxPoolSize) {
            return null;
        }
        
        if($this->pool->getSize() === 0) {
            $this->init();
        }
        
        if($this->pool->getSize() > 0) {
            $originalObject         = $this->pool->pop();
            $decorator              = $this->factory->createDecorator($originalObject, $this);
            $this->borrowed[spl_object_id($decorator)] = $decorator;
            
            if($this->delayPoolReduction > 0) {
                $this->lastBorrowAt = time();
            }
            
            return $decorator;
        }
        
        $decorator               = $this->factory->createDecorator($this->factory->createObject(), $this);
        $this->borrowed[spl_object_id($decorator)] = $decorator;
        
        return $decorator;
    }
    
    public function return(object $object): void
    {
        if(false === array_key_exists(spl_object_id($object), $this->borrowed)) {
            
            if($object instanceof DisposableInterface) {
                $object->dispose();
            }
            
            return;
        }
        
        unset($this->borrowed[spl_object_id($object)]);
        
        $originalObject             = $object->getOriginalObject();
        
        if($object instanceof DisposableInterface) {
            $object->dispose();
        }
        
        //
        // Reduction algorithm:
        // We don't reduce the pool size if the delay time has not expired.
        // This is necessary to avoid frequent creation and destruction of objects.
        //
        $isReduceTimeout            = $this->lastBorrowAt === 0 || (time() - $this->lastBorrowAt) > $this->delayPoolReduction;
        
        if($this->pool->getSize() + 1 > $this->minPoolSize && $isReduceTimeout) {
            return;
        }
        
        if($originalObject !== null) {
            $this->pool->push($originalObject);
        }
    }
    
    public function rebuild(): void
    {
        $this->pool->clear();
        $this->borrowed             = [];
    }
    
    public function getMaxPoolSize(): int
    {
        return $this->maxPoolSize;
    }
    
    public function getMinPoolSize(): int
    {
        return $this->minPoolSize;
    }
    
    public function getMaxWaitTimeout(): int
    {
        return 0;
    }
    
    public function getUsed(): int
    {
        return count($this->borrowed);
    }
    
    public function getPoolSize(): int
    {
        return $this->pool->getSize();
    }
}