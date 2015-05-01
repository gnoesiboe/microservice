<?php

namespace Utility;

/**
 * Class ConstraintListSet
 */
final class ConstraintListSet implements \IteratorAggregate
{

    /**
     * @var array
     */
    private $constraintLists = array();

    /**
     * @param array $constraintLists
     */
    public function __construct(array $constraintLists)
    {
        $this->setConstraintLists($constraintLists);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->constraintLists);
    }

    /**
     * @param string $key
     *
     * @return ConstraintList
     */
    public function get($key)
    {
        $this->validateHas($key);

        return $this->constraintLists[$key];
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->constraintLists);
    }

    /**
     * @param string $key
     *
     * @throws \UnexpectedValueException
     */
    private function validateHas($key)
    {
        if ($this->has($key) === false) {
            throw new \UnexpectedValueException("No constraint-set set for key {$key}");
        }
    }

    /**
     * @param array $constraintLists
     */
    private function setConstraintLists(array $constraintLists)
    {
        foreach ($constraintLists as $key => $constraintList) {
            /** @var string $key */
            /** @var ConstraintList $constraintList */

            $this->setConstraintList($key, $constraintList);
        }
    }

    /**
     * @param string $key
     * @param ConstraintList $constraintList
     *
     * @throws \UnexpectedValueException
     */
    private function setConstraintList($key, ConstraintList $constraintList)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException("Key should be of type string");
        }

        $this->constraintLists[$key] = $constraintList;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->constraintLists);
    }
}
