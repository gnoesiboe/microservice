<?php

namespace Utility\Validator;

use Utility\Exception\ValidationException;
use Utility\Validator;

/**
 * Class Validator
 */
final class StringValidator extends Validator
{

    /** @var string */
    const ERROR_INVALID = 'invalid';

    /**
     * @param string $value
     *
     * @throws ValidationException
     */
    public function validate($value)
    {
        if (is_string($value) === false) {
            throw $this->createValidationException(self::ERROR_INVALID);
        }
    }

    /**
     * @return array
     */
    protected function defineErrorMessages()
    {
        return array(
            self::ERROR_INVALID => 'Value should be of type string'
        );
    }
}
