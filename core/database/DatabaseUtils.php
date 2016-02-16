<?php

	class DatabaseUtils{
		
		public static function runScript($filename){
			$scriptFile = fopen($filename, 'r');

			$script = fread($scriptFile , filesize($filename));

			$parts = explode(';', $script);
			
			$statement = DatabaseConnection::getInstance()->createStatement();

			foreach ($parts as $query ) {
					$statement->execute($query);
			}

		}

	}