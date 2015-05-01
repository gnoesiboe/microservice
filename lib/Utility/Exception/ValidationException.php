<?php

namespace Utility\Exception;

use Utility\Validator;

/**
 * Class ValidationException
 */
final class ValidationException extends \Exception
{

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @param string $identifier
     * @param string $message
     * @param Validator $validator
     */
    public function __construct($identifier, $message, Validator $validator)
    {
        parent::__construct($message);

        $this->identifier = $identifier;
        $this->validator = $validator;
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
