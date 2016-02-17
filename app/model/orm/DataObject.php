<?php
	/*
		DataObject Class
		This class provides the required mechanisms to
		implement object persistance to a database
	 */


	public abstract class DataObject{

		/*
			Determines if this object exists in the 
			database schema.
		 */
		private $existsInSchema;

		/*
			Determines if this object has ben edited.
		 */
		private $edited;


		public function __construct(){
			$existsInSchema = false;

			$edited = false;
		}

		public function isEdited(){
			return $this->edited;
		}

		public function existsInSchema(){
			return $this->existsInSchema;
		}

		public function setEdited($edited){
			$this->edited = $edited;
		}

		public function setExistsInSchema($existsInSchema){
			$this->existsInSchema = $existsInSchema;
		}


		/**
		 * Updates or Inserts the object in the database.
		 */
		public function persist(){
			if( !$this->existsInSchema ){

				$this->insert();
			}else if( $this->edited ){

				$this->update();
			}

		}

		/**
		 * 
		 */
		public abstract function update();

		/**
		 * 
		 */
		public abstract function insert();
		
	}	
	
