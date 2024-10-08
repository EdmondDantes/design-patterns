<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

use IfCastle\Exceptions\UnexpectedValue;

class ExecutionPlan                 implements ExecutionPlanInterface
{
    /**
     * @var array<string, string[]>
     */
    protected array $stages         = [];
    
    protected string $currentStage  = '';
    
    public function __construct(
        protected readonly HandlerExecutorInterface $handlerExecutor,
        array $stages,
        protected readonly PlanExecutorInterface $planExecutor = new SequentialPlanExecutor
    )
    {
        foreach ($stages as $stage) {
            $this->stages[$stage]   = [];
        }
    }
    
    #[\Override]
    public function getCurrentStage(): string
    {
        return $this->currentStage;
    }
    
    #[\Override]
    public function executePlan(): void
    {
        $this->planExecutor->executePlanStages($this->stages, $this->setCurrentStage(...), $this->handlerExecutor);
    }
    
    /**
     * @throws UnexpectedValue
     */
    #[\Override]
    public function addStageHandler(
        string $stage,
        mixed $handler,
        InsertPositionEnum  $insertPosition = InsertPositionEnum::TO_END
    ): static
    {
        if(false === array_key_exists($stage, $this->stages)) {
            throw new UnexpectedValue('$stage', $stage, 'is not a valid stage');
        }
        
        if(in_array($handler, $this->stages[$stage], true)) {
            return $this;
        }
        
        if($insertPosition === InsertPositionEnum::TO_START) {
            array_unshift($this->stages[$stage], $handler);
            
            return $this;
        }
        
        $this->stages[$stage][]     = $handler;
        
        return $this;
    }
    
    protected function setCurrentStage(string $stage): void
    {
        $this->currentStage         = $stage;
    }
}