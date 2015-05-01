<?php

namespace Utility\Validator;

use Utility\Exception\ValidationException;
use Utility\Validator;

/**
 * Class JsonValidator
 */
final class JsonValidator extends Validator
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
        (new StringValidator())
            ->validate($value);

        json_decode($value);

        if (json_last_error() !== JSON_ERROR_NONE) {
            if (function_exists('json_last_error_msg')) {
                $message = json_last_error_msg();
            } else {
                $message = $this->extractMessageFromJsonLastError();
            }

            $this->clearJsonLastError();

            throw $this->createValidationException(self::ERROR_INVALID, array('%message%' => $message));
        }
    }

    /**
     * @return string
     */
    private function extractMessageFromJsonLastError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded.';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch.';

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found.';

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON.';

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded.';

            default:
                return 'Unknown error.';
        }
    }

    private function clearJsonLastError()
    {
        json_encode(null);
    }

    /**
     * @return array
     */
    protected function defineErrorMessages()
    {
        return array(
            self::ERROR_INVALID => 'Value is not a valid json string. Error: %message%'
        );
    }
}
