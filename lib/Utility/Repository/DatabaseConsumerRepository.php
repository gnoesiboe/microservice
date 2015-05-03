<?php

namespace Utility\Repository;

use Domain\Entity\Consumer;
use Domain\Factory\DatabaseConsumerFactoryInterface;
use Domain\Repository\ConsumerRepositoryInterface;
use Domain\ValueObject\Username;
use Utility\Database\DatabaseConnectionInterface;

/**
 * Class DatabaseConsumerRepository
 */
final class DatabaseConsumerRepository implements ConsumerRepositoryInterface
{
    /**
     * @var DatabaseConnectionInterface
     */
    private $connection;

    /**
     * @var DatabaseConsumerFactoryInterface
     */
    private $databaseConsumerFactory;

    /**
     * @param DatabaseConnectionInterface $connection
     * @param DatabaseConsumerFactoryInterface $databaseConsumerFactory
     */
    public function __construct(DatabaseConnectionInterface $connection, DatabaseConsumerFactoryInterface $databaseConsumerFactory)
    {
        $this->connection = $connection;
        $this->databaseConsumerFactory = $databaseConsumerFactory;
    }

    /**
     * @param Username $username
     *
     * @return bool
     */
    public function hasConsumerWithUsername(Username $username)
    {
        $stmt = $this->connection->prepareStatement('SELECT COUNT(*) AS the_count FROM consumer WHERE username = ?');

        $stmt->execute(array($username->getValue()));

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int)$result['the_count'] > 0;
    }

    /**
     * @param string $uuid
     *
     * @return Consumer|null
     */
    public function getOneByUUID($uuid)
    {
        $stmt = $this->connection->prepareStatement('SELECT * FROM consumer WHERE uuid = ?');

        $stmt->execute(array($uuid));

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($results) === 0) {
            return null;
        }

        return $this->databaseConsumerFactory->createConsumer($results[0]);
    }

    /**
     * @param Consumer $consumer
     */
    public function persist(Consumer $consumer)
    {
        $stmt = $this->connection->prepareStatement('INSERT INTO consumer (uuid, username, password) VALUES (?, ?, ?)');

        $stmt->execute(array(
            $consumer->getUUID()->getValue(),
            $consumer->getUsername()->getValue(),
            $consumer->getPassword()->getValue()
        ));
    }
}
