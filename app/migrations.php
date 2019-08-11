<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Service\ConfigService;

$config = new ConfigService();

$dbHost     = $config->get('database_host');
$dbName     = $config->get('database_name');
$dbPort     = $config->get('database_port');
$dbUser     = $config->get('database_user');
$dbPassword = $config->get('database_password');
$uLogin     = $config->get('user_login');
$uPassword  = $config->get('user_password');
$uName      = $config->get('user_name');
$uAmount    = $config->get('user_amount');

$sql = file_get_contents(__DIR__ . '/queries.sql');
$sql = sprintf(
    $sql,
    $uLogin,
    password_hash($uPassword, PASSWORD_DEFAULT),
    $uName,
    $uAmount
);

$pdo = new \PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPassword);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->query("CREATE DATABASE IF NOT EXISTS $dbName");
$pdo->query("USE $dbName");
$pdo->exec($sql);

echo 'Done!';