<?php

namespace Utility\Validator;

use Utility\Exception\ValidationException;
use Utility\Validator;

/**
 * Class IntegerValidator
 */
final class IntegerValidator extends Validator
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
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw $this->createValidationException(self::ERROR_INVALID);
        }
    }

    /**
     * @return array
     */
    protected function defineErrorMessages()
    {
        return array_merge(parent::defineErrorMessages(), array(
            self::ERROR_INVALID => 'Value should be an integer'
        ));
    }
}
