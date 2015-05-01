<?php

namespace Domain\ValueObject;

use Domain\Exception\DomainException;
use Rhumsaa\Uuid\Uuid as BaseUuid;

/**
 * Class GUID
 */
final class UUID extends String
{

    /**
     * @param mixed $value
     *
     * @throws DomainException
     */
    protected function validateValue($value)
    {
        parent::validateValue($value);

        $match = preg_match('/' . BaseUuid::VALID_PATTERN . '/', $value);

        if (is_int($match) === false || $match === 0) {
            throw new DomainException('Pattern does not match patther: ' . BaseUuid::VALID_PATTERN);
        }
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return new static((string)BaseUuid::uuid4());
    }
}
