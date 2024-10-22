<?php

namespace IfCastle\DesignPatterns\CircuitBreaker;

use IfCastle\DesignPatterns\CircuitBreaker\BackoffStrategy\BackoffStrategyInterface;

class CircuitBreaker                implements CircuitBreakerInterface
{
    protected CircuitBreakerStateEnum $state = CircuitBreakerStateEnum::CLOSED;
    
    protected int $lastCalledAt       = 0;
    protected int $lastSuccessAt      = 0;
    protected int $successCount       = 0;
    protected int $failureCount       = 0;
    protected int $totalFailureCount  = 0;
    protected int $totalCount         = 0;
    protected int $currentDelay       = 0;
    
    public function __construct(
        protected BackoffStrategyInterface $backoffStrategy,
        protected int $failureThreshold = 3,
        protected int $successThreshold = 2
    ) {}
    
    /**
     * Registers a successful call, resets failure counters,
     * and sets the state to CLOSED if in HALF_OPEN state.
     */
    public function registerSuccess(): void
    {
        $this->lastSuccessAt        = time();
        $this->lastCalledAt         = $this->lastSuccessAt;
        $this->successCount++;
        $this->totalCount++;
        $this->failureCount         = 0;
        
        if ($this->state === CircuitBreakerStateEnum::HALF_OPEN && $this->successCount >= $this->successThreshold) {
            $this->state            = CircuitBreakerStateEnum::CLOSED;
            $this->resetCounts();
        }
    }
    
    /**
     * Registers a failed call, increments failure counters,
     * and transitions to OPEN state if the failure threshold is reached.
     */
    public function registerFailure(): void
    {
        $this->totalCount++;
        $this->totalFailureCount++;
        $this->failureCount++;
        $this->lastCalledAt         = time();
        
        if ($this->failureCount >= $this->failureThreshold) {
            $this->currentDelay     = $this->backoffStrategy->calculateDelay($this);
            $this->state            = $this->currentDelay > 0 ? CircuitBreakerStateEnum::OPEN : CircuitBreakerStateEnum::CLOSED;
        }
    }
    
    /**
     * Returns the current state of the Circuit Breaker.
     */
    public function getState(): CircuitBreakerStateEnum
    {
        return $this->state;
    }
    
    /**
     * Checks if the Circuit Breaker can be invoked based on its state.
     */
    public function canBeInvoked(): bool
    {
        if ($this->state === CircuitBreakerStateEnum::CLOSED) {
            return true;
        }
        
        if($this->state === CircuitBreakerStateEnum::HALF_OPEN) {
            return true;
        }
        
        if ($this->state === CircuitBreakerStateEnum::OPEN
            && (time() - $this->lastCalledAt) >= $this->currentDelay) {
            
            $this->state            = CircuitBreakerStateEnum::HALF_OPEN;
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns the total number of calls.
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
    
    /**
     * Returns the timestamp of the last call.
     */
    public function getLastCalledAt(): int
    {
        return $this->lastCalledAt;
    }
    
    /**
     * Returns the timestamp of the last successful call.
     */
    public function getLastSuccessAt(): int
    {
        return $this->lastSuccessAt;
    }
    
    /**
     * Returns the total number of errors.
     */
    public function getTotalFailureCount(): int
    {
        return $this->totalFailureCount;
    }
    
    /**
     * Returns the failure threshold value.
     */
    public function getFailureThreshold(): int
    {
        return $this->failureThreshold;
    }
    
    /**
     * Returns the success threshold value.
     */
    public function getSuccessThreshold(): int
    {
        return $this->successThreshold;
    }
    
    /**
     * Returns the current number of consecutive failures.
     */
    public function getFailureCount(): int
    {
        return $this->failureCount;
    }
    
    /**
     * Returns the current number of consecutive successes.
     */
    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
    
    /**
     * Resets the Circuit Breaker to its initial state.
     */
    public function reset(): void
    {
        $this->state                = CircuitBreakerStateEnum::CLOSED;
        $this->resetCounts();
        $this->currentDelay         = 0;
    }
    
    /**
     * Resets counters for failures, successes, and call count.
     */
    private function resetCounts(): void
    {
        $this->failureCount         = 0;
        $this->successCount         = 0;
        $this->totalCount            = 0;
    }
}