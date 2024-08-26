<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

/**
 * @template T
 *
 * This type of Pipeline implementation works in such a way that it allows only the substitution of arguments,
 * but not the Target or the list of interceptors.
 *
 * However, any of the handlers can do the following:
 *
 * * Stop the execution. In this case, only the main handler, the Target, will be executed.
 * * Throw an exception. In this case, the execution will be interrupted.
 */
class InterceptorPipeline           implements InterceptorPipelineInterface
{
    protected bool $isStopped       = false;
    protected \WeakReference|null $nextContext = null;
    
    public function __construct(
        protected object $target,
        protected array $arguments,
        InterceptorInterface ...$interceptors
    )
    {
        foreach ($interceptors as $interceptor) {
            
            $interceptor->intercept($this->nextContext?->get() ?? $this);
            
            if ($this->isStopped) {
                break;
            }
        }
    }
    
    /**
     * @return T
     */
    #[\Override]
    public function getTarget(): object
    {
        return $this->target;
    }
    
    #[\Override]
    public function getArguments(): array
    {
        return $this->arguments;
    }
    
    #[\Override]
    public function withArguments(array $arguments): static
    {
        $clone                      = clone $this;
        $this->nextContext          = \WeakReference::create($clone);
        $clone->nextContext         = null;
        $clone->arguments           = $arguments;
        return $this;
    }
    
    #[\Override]
    public function stop(): void
    {
        $this->isStopped            = true;
    }
}