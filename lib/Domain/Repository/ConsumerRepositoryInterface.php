<?php

namespace Domain\Repository;

use Domain\Entity\Consumer;
use Domain\ValueObject\Username;

/**
 * Interface ConsumerRepository
 */
interface ConsumerRepositoryInterface
{

    /**
     * @param Username $username
     *
     * @return bool
     */
    public function hasConsumerWithUsername(Username $username);

    /**
     * @param string $uuid
     *
     * @return Consumer|null
     */
    public function getOneByUUID($uuid);

    /**
     * @param Consumer $consumer
     */
    public function persist(Consumer $consumer);
}
