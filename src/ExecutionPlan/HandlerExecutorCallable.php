<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

final class HandlerExecutorCallable implements HandlerExecutorInterface
{
    public function executeHandler(mixed $handler, string $stage, mixed ...$parameters): mixed
    {
        if(is_callable($handler)) {
            return $handler($stage, ...$parameters);
        }
        
        return null;
    }
}