<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

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
            	if($_CONFIG["DEBUG"] == "true"){	
            		die(mysqli_error($this->dbConnection));
	            }else{
	            	die("Database Query Error");
	            }
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
            	if($_CONFIG["DEBUG"] == "true"){	
            		die(mysqli_error($this->dbConnection));
	            }else{
	            	die("Database Query Error");
	            }
	        }
		}

		public function executeScalar($query){
			//not implemented yet
		}
	}