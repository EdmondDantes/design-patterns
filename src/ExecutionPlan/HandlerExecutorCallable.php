<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

final class HandlerExecutorCallable implements HandlerExecutorInterface
{
    public function executeHandler(mixed $handler, string $stage): void
    {
        if(is_callable($handler)) {
            $handler($stage);
        }
    }
}