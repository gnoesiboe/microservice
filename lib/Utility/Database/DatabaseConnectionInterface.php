<?php

namespace Utility\Database;

/**
 * Interface DatabaseConnectionInterface
 */
interface DatabaseConnectionInterface
{

    /**
     * @param string $query
     *
     * @return \PDOStatement
     */
    public function createStatement($query);
}
