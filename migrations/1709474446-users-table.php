<?php

class UsersTable {
    public function getQuery(): string {
        return "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mail VARCHAR(40) NOT NULL,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(50) NOT NULL,
            type VARCHAR(15) NOT NULL
        )";
    }
}
