<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Iterators;

interface IteratorWithPathInterface
{
    /**
     * Returns a current path from root node to current node
     */
    public function getPath(): array;
}