<?php

class DropFkImages {
	public function getQuery(): string {
		return "ALTER TABLE images
			DROP FOREIGN KEY images_ibfk_2
		";
	}
}
