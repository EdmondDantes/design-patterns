<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface ExecutionPlanInterface
{
    public function getCurrentStage(): string;
    
    public function executePlan(): void;
    
    public function addStageHandler(
        string $stage,
        mixed $handler,
        InsertPositionEnum $insertPosition = InsertPositionEnum::TO_END
    ): static;
}