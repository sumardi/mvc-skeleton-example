<?php

namespace Framework;

use App\Config;

class Database
{
    /**
     * Database connection
     * 
     * @var \PDO
     */
    private $connection;

    /**
     * Database instance
     * 
     * @var \Framework\Database
     */
    private static $instance;

    /**
     * Constructor
     * Create a new database connection
     * 
     * @return void
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';port=' . Config::DB_PORT;
        try {
            $this->connection = new \PDO($dsn, Config::DB_USER, Config::DB_PASS);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * Get database connection
     * 
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get a database instance, if no instance
     * then create a new one.
     * 
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            // If no instance, then make a new one.
            self::$instance = new self();
        }
        return self::$instance;
    }
}
