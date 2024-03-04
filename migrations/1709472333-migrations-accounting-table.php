<?php

class MigrationsAccountingTable {
    public function getQuery(): string {
        return "CREATE TABLE IF NOT EXISTS migrations_accounting (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            status varchar(30) NOT NULL
        )";
    }
}
