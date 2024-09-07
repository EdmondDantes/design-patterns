<?php
declare(strict_types=1);

namespace IfCastle\DesignPatterns\Handler;

final readonly class WeakStaticHandler implements InvokableInterface
{
    private mixed $handler;
    private \WeakReference $object;
    
    public function __construct(callable $handler, object $object)
    {
        $this->handler              = $handler;
        $this->object               = \WeakReference::create($object);
    }
    
    #[\Override]
    public function __invoke(mixed ...$args): mixed
    {
        $handler                    = $this->handler;
        $object                     = $this->object->get();
        
        if ($object === null) {
            return null;
        }
        
        return $handler($object, ...$args);
    }
}