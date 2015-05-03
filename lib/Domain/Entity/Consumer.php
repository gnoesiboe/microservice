<?php

namespace Domain\Entity;

use Domain\ValueObject\UUID;
use Domain\ValueObject\Password;
use Domain\ValueObject\Username;

/**
 * Class Account
 */
final class Consumer
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var UUID
     */
    private $uuid;

    /**
     * @param UUID $uuid
     * @param Username $username
     * @param Password $password
     */
    public function __construct(UUID $uuid, Username $username, Password $password)
    {
        $this->uuid = $uuid->getValue();
        $this->username = $username->getValue();
        $this->password = $password->getValue();
    }

    /**
     * @return UUID
     */
    public function getUUID()
    {
        return new UUID($this->uuid);
    }

    /**
     * @return Username
     */
    public function getUsername()
    {
        return new Username($this->username);
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return new Password($this->password);
    }
}
