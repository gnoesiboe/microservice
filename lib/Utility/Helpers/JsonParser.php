<?php

namespace Utility\Helpers;

use Utility\Exception\InvalidRequestFormatException;
use Utility\Validator\StringValidator;

/**
 * Class JsonParser
 */
final class JsonParser
{

    /**
     * @param string $input
     * @param bool $assoc
     * @param int $dept
     * @param int $options
     *
     * @return array|object
     *
     * @throws InvalidRequestFormatException
     */
    public function parse($input, $assoc = false, $dept = 512, $options = 0)
    {
        (new StringValidator())
            ->validate($input);

        $output = json_decode($input, $assoc, $dept, $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            if (function_exists('json_last_error_msg')) {
                $message = json_last_error_msg();
            } else {
                $message = $this->extractMessageFromJsonLastError();
            }

            $this->clearJsonLastError();

            throw new InvalidRequestFormatException($message);
        }

        return $output;
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

    /**
     * Makes sure that the next time we want to retrieve the json last error, we don't get
     * the last error from this request :)
     */
    private function clearJsonLastError()
    {
        json_encode(null);
    }
}
