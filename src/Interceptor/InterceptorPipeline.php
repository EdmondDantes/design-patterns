<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

final class InterceptorPipeline     implements InterceptorPipelineInterface
{
    protected bool $isStopped       = false;
    
    public function __construct(
        protected object $target,
        protected array $arguments,
        InterceptorInterface ...$interceptors
    )
    {
        foreach ($interceptors as $interceptor) {
            
            $interceptor->intercept($this);
            
            if ($this->isStopped) {
                break;
            }
        }
    }
    
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
        $clone->arguments           = $arguments;
        return $this;
    }
    
    #[\Override]
    public function stop(): void
    {
        $this->isStopped            = true;
    }
}