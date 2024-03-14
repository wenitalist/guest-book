<?php

class RemoveMiniaturesTable {
	public function getQuery(): string {
		return "DROP TABLE IF EXISTS miniatures";
	}
}
