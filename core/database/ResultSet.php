<?php


	/*
		This file contains the ResultSet class
		which is used to manage the data 
		returned from an sql statement.
	*/

	class ResultSet{
		/*
			Will hold the result object
		*/
        private $result;
        private $row;

        /*
			Creates the ResultSet based on the result object
			that is returned from mysqli
        */
        public function __construct($result){
            $this->result = $result;
        }

        /*
			Moves the cursor forward
			Returns true if the cursor is not finished
			else returns false
        */
        public function next(){
            if( $this->row = $this->result->fetch_assoc() )
                return true;
            return false;
        }

        /*
			Returns the Raw result object
        */
        public function getRawResult(){
            return $this->result;
        }

        /*
			Returns the data of a column from this row.
        */
        public function get($columnName){
            return $this->row[$columnName];
        }

        /*
			Returns the numbers of rows
        */
        public function getRowCount(){
            return $this->result->num_rows;
        }
    }