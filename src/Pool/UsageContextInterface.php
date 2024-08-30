<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface UsageContextInterface
{
    public function getOriginalObject(): object;
    
    public function disposeContext(): void;
}