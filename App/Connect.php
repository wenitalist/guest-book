<?php

namespace App;

class Connect {

    private $connection;
    private static $instance;

    private function __construct() {
        require_once(__DIR__ . '/../env.php');
        $this->connection = new \PDO("mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']}", $env['DB_USER'], $env['DB_PASSWORD']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() { // С помощью этого метода мы получаем экземпляр класса Database

        if (!self::$instance) { // Если экземпляр класса не существует
            self::$instance = new self();  // он создается в переменной $instance
        }
        return self::$instance; // Возвращает экземляр класса
    }

    public function getConnection() {
        return $this->connection;
    }
}