<?php

class RemoveExtraField {
	public function getQuery(): string {
		return "ALTER TABLE images
			DROP COLUMN miniature_id
		";
	}
}
