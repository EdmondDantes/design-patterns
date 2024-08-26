<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

interface InterceptorRegistryInterface
{
    public function registerInterceptor(string|array $interface, object $interceptor): static;
    
    public function registerInterceptorConstructible(string|array $interface, string $class): static;
    
    public function registerInterceptorInjectable(string|array $interface, string $class): static;
    
    public function resolveInterceptors(string $interface): array;
}