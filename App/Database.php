<?php

class Database {

    private $connection;
    private static $instance;

    private function __construct() {
        $this->connection = new PDO('mysql:host=192.168.0.109;dbname=guest_book', 'wenitalist', '904067');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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