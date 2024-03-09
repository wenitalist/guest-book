<?php

class ImagesTable {
	public function getQuery(): string {
		return "CREATE TABLE IF NOT EXISTS images (
            id INT AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL,
            comment_id INT NOT NULL,
            miniature_id INT NOT NULL,
            FOREIGN KEY (comment_id) REFERENCES comments(id),
			FOREIGN KEY (miniature_id) REFERENCES miniatures(id)
        )";
	}
}
