<?php

namespace Utility\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ValidationExceptionSet
 */
final class ValidationExceptionSet extends BadRequestHttpException
{

    /**
     * @var array
     */
    private $exceptions = array();

    /**
     * @param string $key
     * @param ValidationException $exception
     *
     * @return $this
     */
    public function addException($key, ValidationException $exception)
    {
        $this->exceptions[$key] = $exception;

        return $this;
    }

    /**
     * @return array|ValidationException[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * @return bool
     */
    public function hasExceptions()
    {
        return count($this->exceptions) > 0;
    }
}
