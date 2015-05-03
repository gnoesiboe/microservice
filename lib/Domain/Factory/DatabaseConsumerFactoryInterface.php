<?php

namespace Domain\Factory;

use Domain\Entity\Consumer;

/**
 * Interface DatabaseConsumerFactoryInterface
 */
interface DatabaseConsumerFactoryInterface
{

    /**
     * @param array $databaseResults
     *
     * @return Consumer
     */
    public function createConsumer(array $databaseResults);
}
