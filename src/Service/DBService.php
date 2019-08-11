<?php

namespace App\Service;

/**
 * Class DBService
 * @package Service
 */
class DBService
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * DBService constructor.
     * @param ConfigService $config
     */
    public function __construct(ConfigService $config)
    {
        $dbHost     = $config->get('database_host');
        $dbName     = $config->get('database_name');
        $dbPort     = $config->get('database_port');
        $dbUser     = $config->get('database_user');
        $dbPassword = $config->get('database_password');

        $this->pdo = new \PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }
}