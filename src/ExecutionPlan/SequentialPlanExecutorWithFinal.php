<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\ExecutionPlan;

use IfCastle\Exceptions\CompositeException;

/**
 * Mimics the behavior of try-finally:
 *
 * Executes stages in order.
 * If an error occurs, execution stops.
 * However, handlers from the last STAGE will be executed regardless.
 */
final class SequentialPlanExecutorWithFinal implements PlanExecutorInterface
{
    /**
     * @throws \Throwable
     * @throws CompositeException
     */
    #[\Override]
    public function executePlanStages(
        array                    $stages,
        callable                 $stageSetter,
        HandlerExecutorInterface $handlerExecutor,
        mixed                    ...$parameters
    ): void
    {
        $finalStage                 = array_key_last($stages);
        $finalHandlers              = array_pop($stages);
        $errors                     = [];
        
        try {
            foreach ($stages as $stage => $handlers) {
                
                if($handlers === []) {
                    continue;
                }
                
                $stageSetter($stage);
                
                foreach ($handlers as $handler) {
                    $handlerExecutor->executeHandler($handler, $stage, ...$parameters);
                }
            }
        } catch (\Throwable $exception) {
            $errors[]               = $exception;
        }
        
        $stageSetter($finalStage);
        
        foreach ($finalHandlers as $handler) {
            try {
                $handlerExecutor->executeHandler($handler, $finalStage, ...$parameters);
            } catch (\Throwable $exception) {
                $errors[]           = $exception;
            }
        }
        
        if(count($errors) === 1) {
            throw $errors[0];
        }
        
        if(count($errors) > 1) {
            throw new CompositeException('Error execution plan', ...$errors);
        }
    }
}