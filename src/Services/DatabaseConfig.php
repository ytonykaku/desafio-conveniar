<?php
namespace Src\Services;

class DatabaseConfig
{
    public readonly string $driver;
    public readonly string $host;
    public readonly string $port;
    public readonly string $database;
    public readonly string $username;
    public readonly string $password;
    public readonly string $charset;

    public function __construct(array $config)
    {
        $config = require ROOT . 'config/database.php';

        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->charset = $config['charset'];
    }

    public function getDsn(): string
    {
        return 
            sprintf(
                "%s:host=%s;
                port=%s;
                dbname=%s",
                $this->driver,
                $this->host,
                $this->port,
                $this->database,
            );
    }
}