<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\Factory;

interface FactoryInterface
{
    public function createObject(): object;
}
