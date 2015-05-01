<?php

namespace Utility;

/**
 * Class Singleton
 */
abstract class Singleton
{

    /**
     * Prevents direct creation of object and forces the child
     * to use a protected constructor
     */
    protected function __construct()
    {
    }

    /**
     * Makes sure that this instance can also never be cloned
     */
    final private function __clone()
    {
    }

    /**
     * Gets a single instance of the class the static method is called for.
     *
     * @return static
     */
    final public static function getInstance()
    {
        static $instance = null;

        if ($instance instanceof static) {
            return $instance;
        }

        $instance = new static;
        return $instance;
    }
}
