<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

use IfCastle\DI\InitializerInterface;

interface InterceptorRegistryInterface
{
    public function registerInterceptor(string|array $interface, object $interceptor): static;
    
    public function registerInterceptorConstructible(string|array $interface, string $class): static;
    
    public function registerInterceptorInjectable(string|array $interface, string $class): static;
    
    public function runInterceptors(string $interface, object $target, mixed ...$arguments): void;
}