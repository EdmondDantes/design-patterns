<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Immutable;

trait ImmutableTrait
{
    protected bool $isImmutable     = false;
    
    public function isMutable(): bool
    {
        return $this->isImmutable === false;
    }
    
    public function isImmutable(): bool
    {
        return $this->isImmutable === true;
    }
    
    public function asImmutable(): static
    {
        $this->isImmutable = true;
        return $this;
    }
    
    public function cloneAsMutable(): static
    {
        $cloned                     = clone $this;
        $cloned->isImmutable        = false;
        return $cloned;
    }
}