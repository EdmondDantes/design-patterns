<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

final readonly class WeakHandlerExecutor implements HandlerExecutorInterface
{
    private \WeakReference $executor;
    
    public function __construct(callable $handler)
    {
        $this->executor             = \WeakReference::create($handler);
    }
    
    #[\Override]
    public function executeHandler(mixed $handler, string $stage): void
    {
        $executor                   = $this->executor->get();
        
        if(is_callable($executor)) {
            $executor($handler, $stage);
        }
    }
}