<?php

namespace IfCastle\DesignPatterns\CircuitBreaker;

enum CircuitBreakerStateEnum
{
    case CLOSED;
    case OPEN;
    case HALF_OPEN;
}
