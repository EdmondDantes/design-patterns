<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

interface InterceptorInterface
{
    /**
     * Called before the execution of the target.
     */
    public function intercept(InterceptorPipelineInterface $pipeline): void;
}
