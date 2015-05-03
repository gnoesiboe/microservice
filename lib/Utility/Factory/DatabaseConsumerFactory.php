<?php

namespace Utility\Factory;

use Domain\Entity\Consumer;
use Domain\Factory\DatabaseConsumerFactoryInterface;
use Domain\ValueObject\Password;
use Domain\ValueObject\Username;
use Domain\ValueObject\UUID;

/**
 * Class DatabaseConsumerFactory
 */
final class DatabaseConsumerFactory implements DatabaseConsumerFactoryInterface
{

    /**
     * @param array $databaseResults
     *
     * @return Consumer
     */
    public function createConsumer(array $databaseResults)
    {
        return new Consumer(
            new UUID($databaseResults['uuid']),
            new Username($databaseResults['username']),
            new Password($databaseResults['password'])
        );
    }
}
