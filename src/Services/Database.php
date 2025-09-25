<?php

require_once ROOT . 'src/Services/DatabaseConfig.php';

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $configArray = require ROOT . 'config/database.php';
        $config = new DatabaseConfig($configArray);

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO(
                $config->getDsn(),
                $config->username,
                $config->password,
                $options
            );
        } catch (PDOException $e) {
            die('Error during database connection: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function setInstance($instance) 
    {
        self::$instance = $instance;
    }

        private function setConnection($connection) 
    {
        self::$connection = $connection;
    }

    private function __clone() {}
    private function __wakeup() {}

}