<?php

namespace IfCastle\DesignPatterns\CircuitBreaker\BackoffStrategy;

use IfCastle\DesignPatterns\CircuitBreaker\CircuitBreakerInterface;

interface BackoffStrategyInterface
{
    /**
     * Calculates the delay time before the next retry attempt based on the number of failures.
     *
     * @return int The delay time in milliseconds before the next attempt.
     */
    public function calculateDelay(CircuitBreakerInterface $circuitBreaker): int;
}