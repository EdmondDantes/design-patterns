<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

interface InterceptorRegistryInterface
{
    /**
     * Register an interceptor for a given interface.
     *
     * @param string|string[] $interface
     * @param object $interceptor
     *
     * @return static
     */
    public function registerInterceptor(string|array $interface, object $interceptor): static;

    /**
     * Register an interceptor for a given interface.
     *
     * @param string|string[] $interface
     * @param string $class
     *
     * @return static
     */
    public function registerInterceptorConstructible(string|array $interface, string $class): static;

    /**
     * Register an interceptor for a given interface.
     *
     * @param string|string[] $interface
     * @param string $class
     *
     * @return static
     */
    public function registerInterceptorInjectable(string|array $interface, string $class): static;

    public function resolveInterceptors(string $interface): array;
}
