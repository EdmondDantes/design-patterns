<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

final class HandlerExecutorWithClass implements HandlerExecutorInterface
{
    public function executeHandler(mixed $handler, string $stage, mixed ...$parameters): void
    {
        if(is_string($handler) && class_exists($handler)) {
            $handler = new $handler();
        }
        
        if(is_callable($handler)) {
            $handler($stage, ...$parameters);
        }
    }
}