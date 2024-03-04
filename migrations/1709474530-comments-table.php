<?php

class CommentsTable {
    public function getQuery(): string {
        return "CREATE TABLE IF NOT EXISTS comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content VARCHAR(255) NOT NULL,
            date_time DATETIME NOT NULL,
            user_id INT,
            name VARCHAR(50),
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";
    }
}
