<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Pool;

interface FactoryInterface
{
    public function createObject(): object;
    
    public function createDecorator(object $object): DecoratorInterface;
}