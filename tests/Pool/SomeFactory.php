<?php

namespace IfCastle\DesignPatterns\Pool;

use IfCastle\DesignPatterns\Factory\FactoryInterface;

class SomeFactory                   implements FactoryInterface
{
    private int $counter            = 0;
    
    #[\Override]
    public function createObject(): object
    {
        return new SomeObject('object' . ++$this->counter);
    }
}