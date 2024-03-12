<?php

class AddFkImagesComments {
	public function getQuery(): string {
		return "ALTER TABLE images
			ADD FOREIGN KEY (comment_id) REFERENCES comments(id)
			ON DELETE CASCADE 
		";
	}
}
