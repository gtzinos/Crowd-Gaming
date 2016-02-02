<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

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