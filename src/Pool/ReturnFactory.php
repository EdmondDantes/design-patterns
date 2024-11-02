<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

final class ReturnFactory implements ReturnFactoryInterface
{
    #[\Override]
    public function createDecorator(object $originalObject, PoolInterface $pool): object
    {
        return new Decorator($originalObject, $pool);
    }
}
