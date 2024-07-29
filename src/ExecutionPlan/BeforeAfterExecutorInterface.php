<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

interface BeforeAfterExecutorInterface
{
    public function addBeforeHandler(mixed $handler): static;
    public function addHandler(mixed $handler): static;
    public function addAfterHandler(mixed $handler): static;
}