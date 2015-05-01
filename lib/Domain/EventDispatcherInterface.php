<?php

namespace Domain;

/**
 * Interface EventDispatcherInterface
 */
interface EventDispatcherInterface
{

    /**
     * @param EventInterface $event
     *
     * @return $this
     */
    public function trigger(EventInterface $event);

    /**
     * @param string $identifier
     * @param callable $callback
     *
     * @return $this
     */
    public function register($identifier, \Closure $callback);
}
