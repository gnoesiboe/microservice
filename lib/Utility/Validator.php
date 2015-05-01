<?php

namespace Utility;

use Utility\Exception\ValidationException;

/**
 * Class Validator
 */
abstract class Validator
{

    /**
     * @var KeyValueStore
     */
    private $options;

    /**
     * @var KeyValueStore
     */
    private $errorMessages;

    /**
     * @param array $options
     * @param array $errorMessages
     */
    public function __construct(array $options = array(), array $errorMessages = array())
    {
        $this->options = $this->importOptions($options);
        $this->errorMessages = $this->importErrorMessages($errorMessages);
    }

    /**
     * @return KeyValueStore
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * @return KeyValueStore
     */
    protected function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * @param array $errorMessages
     *
     * @return KeyValueStore
     */
    private function importErrorMessages(array $errorMessages)
    {
        $values = array_merge(
            $this->defineErrorMessages(),
            $errorMessages
        );

        return new KeyValueStore($values);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function importOptions(array $options)
    {
        $values = array_merge(
            $this->defineOptions(),
            $options
        );

        return new KeyValueStore($values);
    }

    /**
     * @param string $value
     *
     * @throws ValidationException
     */
    abstract public function validate($value);

    /**
     * @return array
     */
    protected function defineOptions()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function defineErrorMessages()
    {
        return array();
    }

    /**
     * @param string $identifier
     * @param array $replacements
     *
     * @return string
     */
    private function generateErrorMessage($identifier, array $replacements = array())
    {
        $identifier = (string)$identifier;

        $this->validateHasErrorMessage($identifier);

        if (count($replacements) === 0) {
            return $this->errorMessages[$identifier];
        } else {
            return strtr($this->errorMessages[$identifier], $replacements);
        }
    }

    /**
     * @param string $identifier
     * @param array $errorMessageReplacements
     *
     * @return ValidationException
     */
    protected function createValidationException($identifier, array $errorMessageReplacements = array())
    {
        return new ValidationException($identifier, $this->generateErrorMessage($identifier, $errorMessageReplacements), $this);
    }

    /**
     * @param string $identifier
     */
    private function validateHasErrorMessage($identifier)
    {
        if ($this->errorMessages->has($identifier) === false) {
            throw new \UnexpectedValueException("No error message found with identifier: {$identifier}");
        }
    }

    /**
     * @return array
     */
    public function getDefinition()
    {
        return array(
            'validator' => get_called_class(),
            'options' => $this->getOptions()->toArray(),
            'error_messages' => $this->getErrorMessages()->toArray(),
        );
    }
}
