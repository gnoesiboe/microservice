<?php

namespace Utility\Repository;

use Domain\Entity\Consumer;
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
     * @param DatabaseConnectionInterface $connection
     */
    public function __construct(DatabaseConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Username $username
     *
     * @return bool
     */
    public function hasConsumerWithUsername(Username $username)
    {
        $stmt = $this->connection->createStatement('SELECT COUNT(*) AS the_count FROM consumer WHERE username = ?');

        $stmt->execute(array($username->getValue()));

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int)$result['the_count'] > 0;
    }

    /**
     * @param Consumer $consumer
     */
    public function persist(Consumer $consumer)
    {
        $stmt = $this->connection->createStatement('INSERT INTO consumer (guid, username, password) VALUES (?, ?, ?)');

        $stmt->execute(array(
            $consumer->getUUID()->getValue(),
            $consumer->getUsername()->getValue(),
            $consumer->getPassword()->getValue()
        ));
    }
}
