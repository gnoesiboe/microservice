<?php

namespace Domain;

use Utility\Singleton;

/**
 * Class EventDispatcher
 */
final class EventDispatcher extends Singleton implements EventDispatcherInterface
{

    /**
     * @var array|\Closure[]
     */
    private $registrations = array();

    /**
     * @param EventInterface $event
     *
     * @return $this
     */
    public function trigger(EventInterface $event)
    {
        $identifier = $event->getIdentifier();

        $this->validateIdentifier($identifier);

        if (array_key_exists($identifier, $this->registrations) === false) {
            return $this;
        }

        foreach ($this->registrations[$identifier] as $registration) {
            /** @var \Closure $registration */

            $registration($event);
        }

        return $this;
    }

    /**
     * @param string $identifier
     * @param callable $callback
     *
     * @return $this
     */
    public function register($identifier, \Closure $callback)
    {
        $this->validateIdentifier($identifier);

        $this->registrations[$identifier][] = $callback;

        return $this;
    }

    /**
     * @param string $identifier
     */
    private function validateIdentifier($identifier)
    {
        if (is_string($identifier) === false) {
            throw new \UnexpectedValueException('Event identifier should be of type string');
        }
    }
}
