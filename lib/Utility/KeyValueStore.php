<?php

namespace Utility;

/**
 * Class KeyValueStore
 */
class KeyValueStore implements \IteratorAggregate, \ArrayAccess, \Countable, ArrayableInterface
{

    /**
     * @var array
     */
    private $values = array();

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->setValues($values);
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setValues(array $values)
    {
        $this->clearValues();

        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Clears all values
     */
    public function clearValues()
    {
        $this->values = array();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->validateKey($key);
        $this->validateValue($value);

        $this->values[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function remove($key)
    {
        if ($this->has($key) === true) {
            unset($this->values[$key]);
        }

        return $this;
    }

    /**
     * @param string $value
     *
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value)
    {
        // implement to add validation
    }

    /**
     * @param mixed $key
     *
     * @throws \UnexpectedValueException
     */
    protected function validateKey($key)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException('Key should be of type string');
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $this->validateHas($key);

        return $this->values[$key];
    }

    /**
     * @param string $key
     */
    private function validateHas($key)
    {
        if ($this->has($key) === false) {
            throw new \UnexpectedValueException("No value in store with key '{$key}'");
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $this->validateKey($key);

        return array_key_exists($key, $this->values);
    }

    /**
     * @inheritdoc
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param string $offset
     * @param mixed $value
     *
     * @return $this
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);

        return $this;
    }

    /**
     * @param string $offset
     *
     * @return $this
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->values);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->values;
    }
}
