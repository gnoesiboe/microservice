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
     * @param Consumer $consumer
     */
    public function persist(Consumer $consumer);
}
