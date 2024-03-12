<?php

class AddImageId {
	public function getQuery(): string {
		return "ALTER TABLE miniatures
			ADD image_id INT AFTER id
		";
	}
}
