<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface HandlerExecutorInterface
{
    /**
     * @param callable(mixed $handler, string $stage, mixed ...$parameters): mixed $handler
     * @param string $stage
     * @param mixed ...$parameters
     * @return mixed
     */
    public function executeHandler(mixed $handler, string $stage, mixed ...$parameters): mixed;
}
