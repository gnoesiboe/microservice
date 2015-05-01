<?php

namespace Utility\Database;

/**
 * Class DatabaseConnection
 */
final class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     *
     * @return \PDOStatement
     */
    public function createStatement($query)
    {
        return $this->pdo->prepare($query);
    }
}
