<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\IntervalRunner;

use IfCastle\DesignPatterns\CircuitBreaker\BackoffStrategy\ExponentialBackoff;
use IfCastle\DesignPatterns\CircuitBreaker\CircuitBreaker;
use IfCastle\DesignPatterns\CircuitBreaker\CircuitBreakerInterface;

final readonly class IntervalRunner implements IntervalRunnerInterface
{
    private mixed $function;
    private CircuitBreakerInterface $circuitBreaker;
    
    public function __construct(
        callable $function = null,
        CircuitBreakerInterface|null $circuitBreaker = null,
        private float $interval = 1.0,
    )
    {
        $this->function             = $function;
        $this->circuitBreaker       = $circuitBreaker ?? new CircuitBreaker(new ExponentialBackoff);
    }
    
    public function tryInvoke(callable $function = null): void
    {
        $function                   = $function ?? $this->function;
        
        if (false === $this->circuitBreaker->canBeInvoked()) {
            return;
        }
        
        if((time() - $this->circuitBreaker->getInvocationStat()->getLastCalledAt()) < $this->interval) {
            return;
        }
        
        try {
            $function();
            $this->circuitBreaker->registerSuccess();
        } catch (\Throwable) {
            $this->circuitBreaker->registerFailure();
        }
    }
    
    public function shouldInvoke(): bool
    {
        return $this->circuitBreaker->canBeInvoked() && ((time() - $this->circuitBreaker->getInvocationStat()->getLastCalledAt()) >= $this->interval);
    }
    
    public function isSuccessful(): bool
    {
        return $this->circuitBreaker->getInvocationStat()->getFailureCount() === 0;
    }
    
    public function getLastInvocationTime(): int
    {
        return $this->circuitBreaker->getInvocationStat()->getLastCalledAt();
    }
}