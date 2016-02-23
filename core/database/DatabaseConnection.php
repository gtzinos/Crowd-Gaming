<?php


	/*	
		This file contains the DatabaseConnection class
		which is used to connect to a mysql database
	*/

	class DatabaseConnection {

		/*
			Static variable that will hold the connection. 
			It is used to implement the singleton pattern
		*/
		private static $connection;

		/*
			Singleton 
			Creates or returns an existing instance of this
			class if it exists.
		*/
        public static function getInstance(){
        	global $_CONFIG;

            if(!isset(self::$connection))
                self::$connection = new DatabaseConnection( $_CONFIG["DB_ADDRESS"] ,
                											$_CONFIG["DB_USERNAME"],
                											$_CONFIG["DB_PASSWORD"],
                											$_CONFIG["DB_SCHEMA"] , "null" , "null");
              
            return self::$connection;
        }

        /*
			Singleton
			If an instance of this class exists , close it.
        */
        public static function dispose(){
            if( isset(self::$connection))
                self::$connection->close();
        }


        /*
			Will hold the mysql object
        */
		private $dbConnection;

		/*
			Create a database connection based on the parameters
			@param hostname , the hostname or ip address of the database server
			@param user , the username of the user at the database
			@param pass , the user's password
			@param database , the name of the database to connect
			@param socket , the path to the unix domain socket that the database uses, can be left null if a unix socket is not used
			@param port , the port of the database server  ,if left null it will connect using the default port
		*/
		public function __construct($hostname ,$user ,$pass ,$database ,$socket ,$port ){
            if($port!="null" && $socket!="null"){
                // create db from unix domain socket
            }else{
                $this->dbConnection = new mysqli($hostname,$user,$pass,$database);
            	$this->dbConnection->query("SET NAMES utf8");
                $this->dbConnection->query("SET CHARACTER SET utf8");
            }


            if($this->dbConnection->connect_error){
            	throw new DatabaseException("There was an error while trying to connect to the database");
            }
        }

        public function startTransaction(){
        	$this->dbConnection->autocommit(false);
        }

        public function rollback(){
        	$this->dbConnection->rollback();
        	$this->dbConnection->autocommit(true);
        }

        public function commit(){
        	$this->dbConnection->commit();
        	$this->dbConnection->autocommit(true);
        }

        /*
			Creates and returns an sql statement
			@returns Statement
        */
		public function createStatement(){
			$statement = new Statement($this->dbConnection);
			return $statement;
		}

		/*
			Creates , prepares and reuturns an sql prepared Statement.
			@returns PreparedStatement
		*/
		public function prepareStatement($query){
			$preparedStatement = new PreparedStatement($query , $this->dbConnection);
			return $preparedStatement;
		}

		/*
			Closes the connection
		*/
		public function close(){
			$this->dbConnection->close();
		}

		public function getConnection(){
			return $this->dbConnection;
		}
	}