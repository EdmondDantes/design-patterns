<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

final readonly class WeakStaticClosureExecutor implements HandlerExecutorInterface
{
    private \WeakReference $self;
    
    public function __construct(private \Closure $executor, object $self)
    {
        $this->self                 = \WeakReference::create($self);
    }
    
    
    #[\Override]
    public function executeHandler(mixed $handler, string $stage): void
    {
        $self                       = $this->self->get();
        $executor                   = $this->executor;
        
        if(is_callable($executor)) {
            $executor($self, $handler, $stage);
        }
    }
}