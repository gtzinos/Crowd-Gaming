<?php
	
	abstract class DataMapper{

		/*
			Associative array that contains the statements
			The key is the query string
			The value is the actual statement
		 */
		private $statements;

		/*
			Only one prepared statement is created for a query.
			If the statement exists it should be re used.
		 */
		protected function getStatement($query){
			if( !isset( $this->statements[$query] ) ){
				/*
					Statement not set , we must create it
				 */
				$this->statements[$query] = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->statements[$query];
		}
	}