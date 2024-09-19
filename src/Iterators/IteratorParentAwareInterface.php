<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Iterators;

interface IteratorParentAwareInterface
{
    public function getParentIterator(): \Iterator|null;
    
    public function getParent(): object|null;
}