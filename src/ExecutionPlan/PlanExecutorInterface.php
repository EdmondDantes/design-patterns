<?php

declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface PlanExecutorInterface
{
    public function executePlanStages(array $stages, callable $stageSetter, HandlerExecutorInterface $handlerExecutor, mixed ...$parameters): void;
}
