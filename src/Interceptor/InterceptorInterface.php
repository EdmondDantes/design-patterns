<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Interceptor;

interface InterceptorInterface
{
    public function intercept(InterceptorPipelineInterface $pipeline): void;
}