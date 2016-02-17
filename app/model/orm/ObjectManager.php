<?php
	include_once 'DataObject.php';

	public class ObjectManager{

		/*
			All the objects that were retrieved or added
		 */
		private $dataObjects;


		public function getModerator($id){
			//Not Implemented	
		}

		public function getPlayer($id){
			//Not Implemented
		}

		public function getExaminer($id){
			//Not Implemented
		}

		public function getQuestionnaire( $id , $relationLevel){
			//Not Implemented
		}

		public function getQuestionGroup( $id , $relationLevel){
			//Not Implemented
		}

		public function getQuestion( $id , $relationLevel){
			//Not Implemented
		}


		/**
		 * Finds and retrieves a answer from
		 * the data source
		 * @param  [integer] $id [The id of the answer]
		 * @return [Answer]     [The answer with the required id]
		 */
		public function getAnswer($id){
			//Not Implemented
		}


		/**
		 * Adds a new object to the manager.
		 * This object will be inserted when the flush 
		 * method is called
		 * @param  [type] $dataObject [description]
		 */
		public function persist($dataObject){
		
			$this->dataObjects[] = $dataObject;
		}


		/**
		 * Updates or Inserts all the objects that
		 * were edited or are new.
		 */
		public function flush(){

			foreach ($this->dataObjects as $dataObject) {
				$dataObject->persist();
			}
		}
		
	}