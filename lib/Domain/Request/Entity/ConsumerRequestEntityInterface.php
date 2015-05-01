<?php

namespace Domain\Request\Entity;

/**
 * Interface ConsumerRequestEntityInterface
 */
interface ConsumerRequestEntityInterface
{

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();
}
