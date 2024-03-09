<?php

class MiniImagesTable {
	public function getQuery(): string {
		return "CREATE TABLE IF NOT EXISTS miniatures (
            id INT AUTO_INCREMENT PRIMARY KEY,
            miniature_blob BLOB
        )";
	}
}
