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
    
    public function __construct(protected readonly HandlerExecutorInterface $handlerExecutor, string ...$stages)
    {
        foreach ($stages as $stage) {
            $this->stages[$stage]   = [];
        }
    }
    
    #[\Override]
    public function executePlan(): void
    {
        foreach ($this->stages as $stage => $handlers) {
            $this->executeStageHandlers($stage, $handlers);
        }
    }
    
    protected function executeStageHandlers(string $stage, array $handlers): void
    {
        foreach ($handlers as $handler) {
            $this->handlerExecutor->executeHandler($handler, $stage);
        }
    }
    
    /**
     * @throws UnexpectedValue
     */
    #[\Override]
    public function addStageHandler(string $stage, mixed $handler): static
    {
        if(false === array_key_exists($stage, $this->stages)) {
            throw new UnexpectedValue('$stage', $stage, 'is not a valid stage');
        }
        
        if(in_array($handler, $this->stages[$stage], true)) {
            return $this;
        }
        
        $this->stages[$stage][]     = $handler;
        
        return $this;
    }
}