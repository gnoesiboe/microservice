<?php

namespace Domain\Exception;

use Domain\ValueObject\Username;

/**
 * Class UsernameAlreadyExistsException
 */
final class UsernameAlreadyExistsException extends DomainException
{
    /**
     * @var Username
     */
    private $username;

    /**
     * @param Username $username
     */
    public function __construct(Username $username, $message)
    {
        $this->username = $username;

        parent::__construct($message);
    }

    /**
     * @return Username
     */
    public function getUsername()
    {
        return $this->username;
    }
}
