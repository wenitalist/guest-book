<?php

class ChangeFormatField {
	public function getQuery(): string {
		return "ALTER TABLE comments MODIFY COLUMN content TEXT NOT NULL";
	}
}
