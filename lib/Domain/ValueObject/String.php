<?php

namespace Domain\ValueObject;

use Domain\Exception\DomainException;

/**
 * Class String
 */
class String
{

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @param string $value
     */
    private function setValue($value)
    {
        $this->validateValue($value);

        $this->value = $value;
    }

    /**
     * @param string $value
     *
     * @throws DomainException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new DomainException('Value should be of type string');
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
