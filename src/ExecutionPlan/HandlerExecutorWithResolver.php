<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

use IfCastle\DI\AutoResolverInterface;
use IfCastle\DI\ContainerInterface;
use IfCastle\DI\DependencyInterface;
use IfCastle\DI\DisposableInterface;
use IfCastle\DI\InitializerInterface;
use IfCastle\DI\ResolverInterface;

final readonly class HandlerExecutorWithResolver implements HandlerExecutorInterface
{
    public function __construct(private ContainerInterface $container, private ResolverInterface $resolver) {}
    
    #[\Override]
    public function executeHandler(mixed $handler, string $stage): void
    {
        if($handler instanceof InitializerInterface) {
            $handler                = $handler->executeInitializer($this->container);
        }
        
        if($handler instanceof AutoResolverInterface) {
            $handler                = $handler->resolveDependencies($this->container);
        } elseif ($handler instanceof DependencyInterface) {
            $handler                = $this->resolver->resolveDependency($handler, $this->container);
        }

        try {
            if($handler instanceof StageHandlerInterface) {
                $handler->handleStage($stage);
            }
        } finally {
            if($handler instanceof DisposableInterface) {
                $handler->dispose();
            }
        }
    }
}