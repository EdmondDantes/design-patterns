<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\HandlerWithHash;

interface HandlerWithHashAwareInterface
{
    public function findHandlerByHash(string|int|null $hash): ?callable;
}