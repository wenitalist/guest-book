<?php

class AddFkMiniatures {
	public function getQuery(): string {
		return "ALTER TABLE miniatures
			ADD FOREIGN KEY (image_id) REFERENCES images(id)
			ON DELETE CASCADE
		";
	}
}
