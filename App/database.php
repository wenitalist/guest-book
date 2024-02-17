<?php

class database {

    private $connection;
    private $instance;

    public function __construct() {
        
        $this->connection = new PDO('mysql:host=192.168.0.109;dbname=guest_book', 'wenitalist', '904067');
    }
}