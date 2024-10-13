<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface HandlerExecutorInterface
{
    public function executeHandler(mixed $handler, string $stage, mixed ...$parameters): void;
}