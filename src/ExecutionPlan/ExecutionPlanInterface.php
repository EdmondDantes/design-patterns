<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface ExecutionPlanInterface
{
    public function executePlan(): void;
    public function addStageHandler(string $stage, mixed $handler): static;
}