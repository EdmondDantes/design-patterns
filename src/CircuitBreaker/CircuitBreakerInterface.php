<?php

namespace IfCastle\DesignPatterns\CircuitBreaker;

interface CircuitBreakerInterface
{
    public function registerSuccess(): void;
    
    public function registerFailure(): void;
    
    public function getState(): CircuitBreakerStateEnum;
    
    public function canBeInvoked(): bool;
    
    public function getTotalCount(): int;
    
    public function getLastCalledAt(): int;
    
    public function getLastSuccessAt(): int;
    
    public function getTotalFailureCount(): int;
    
    public function getFailureThreshold(): int;
    
    public function getSuccessThreshold(): int;
    
    public function getFailureCount(): int;
    
    public function getSuccessCount(): int;
    
    public function reset(): void;
}