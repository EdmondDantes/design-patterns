<?php

namespace IfCastle\DesignPatterns\CircuitBreaker\BackoffStrategy;

interface BackoffStrategyInterface
{
    /**
     * Calculates the delay time before the next retry attempt based on the number of failures.
     *
     * @param int $failureAttempts
     *
     * @return float The delay time in seconds before the next attempt.
     */
    public function calculateDelay(int $failureAttempts): float;
}