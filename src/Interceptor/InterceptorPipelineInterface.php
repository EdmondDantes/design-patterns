<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

/**
 * @template T
 *
 * This type of Pipeline implementation works in such a way that it allows only the substitution of arguments,
 * but not the Target or the list of interceptors. However, any of the handlers can do the following:
 *
 * * Stop the execution. In this case, only the main handler, the Target, will be executed.
 * * Throw an exception. In this case, the execution will be interrupted.
 */
interface InterceptorPipelineInterface
{
    /**
     * @return T
     */
    public function getTarget(): object;
    
    public function getArguments(): array;
    
    public function withArguments(array $arguments): static;
    
    public function stop(): void;
}