<?php

	class Statement {

		private $dbConnection;

		public function __construct($dbConnection){
			$this->dbConnection = $dbConnection;
		}

		public function execute($query){
			$result = $this->dbConnection->query($query);
			global $_CONFIG;
            /*
				Error Handling
            */
            if (mysqli_error($this->dbConnection)){
            	throw new DatabaseException("Error when trying to execute update query ".$query);
	        }

	        $resultSet = new ResultSet($result);
            return $resultSet;
		}

		public function executeUpdate($query){
			$this->dbConnection->query($query);
			global $_CONFIG;
            /*
				Error Handling
            */
            if (mysqli_error($this->dbConnection)){
            	throw new DatabaseException("Error when trying to execute update query ".$query);
	        }
		}

		public function executeScalar($query){
			//not implemented yet
		}
	}