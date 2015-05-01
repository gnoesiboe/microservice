<?php

namespace Utility;

/**
 * Class ConstraintList
 */
final class ConstraintList implements \IteratorAggregate
{

    /**
     * @var array
     */
    private $validators;

    /**
     * @param array|Validator $validators
     */
    public function __construct(array $validators)
    {
        $this->setValidators($validators);
    }

    /**
     * @param array|Validator $validators
     *
     * @return $this
     */
    public function setValidators(array $validators)
    {
        $this->clearValidators();

        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }

        return $this;
    }

    /**
     * @param Validator $validator
     *
     * @return $this
     */
    public function addValidator(Validator $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * @return $this
     */
    public function clearValidators()
    {
        $this->validators = array();

        return $this;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->validators);
    }
}
