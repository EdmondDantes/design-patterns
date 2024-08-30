<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface DecoratorInterface
{
    public function getOriginalObject(): object;
}