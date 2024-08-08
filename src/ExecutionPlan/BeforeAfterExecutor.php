<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

class BeforeAfterExecutor           extends ExecutionPlan
                                    implements BeforeAfterExecutorInterface
{
    public const string BEFORE       = '-';
    public const string MAIN         = '*';
    public const string AFTER        = '+';
    
    public function __construct(HandlerExecutorInterface $handlerExecutor)
    {
        parent::__construct(
            $handlerExecutor,
            self::AFTER, self::MAIN, self::BEFORE
        );
    }
    
    public function addBeforeHandler(mixed $handler): static
    {
        return $this->addStageHandler(self::BEFORE, $handler);
    }
    
    public function addHandler(mixed $handler): static
    {
        return $this->addStageHandler(self::MAIN, $handler);
    }
    
    public function addAfterHandler(mixed $handler): static
    {
        return $this->addStageHandler(self::AFTER, $handler);
    }
}