<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

/**
 * Class WeakStaticClosureExecutor
 *
 * Creates a handler through a static closure, with this object passed as the first argument.
 * This way, the class allows creating handlers that do not create additional
 * references to the $this object while still calling its internal methods through the closure.
 *
 * Example:
 * ```php
 * new WeakStaticClosureExecutor(static fn($self, $handler, $stage, mixed ...$parameters) => $self->handlerExecutor($handler, $stage, ...$parameters), $this)
 * ```
 */
final readonly class WeakStaticClosureExecutor implements HandlerExecutorInterface
{
    private \WeakReference $self;
    
    public function __construct(private \Closure $executor, object $self)
    {
        $this->self                 = \WeakReference::create($self);
    }
    
    
    #[\Override]
    public function executeHandler(mixed $handler, string $stage, mixed ...$parameters): void
    {
        $self                       = $this->self->get();
        $executor                   = $this->executor;
        
        if(is_callable($executor)) {
            $executor($self, $handler, $stage, ...$parameters);
        }
    }
}