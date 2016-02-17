<?php 

	include_once 'QuestionGroup.php';


	class Questionnaire extends DataObject{

		private $id;
		private $name;
		private $description;
		private $language;
		private $public;
		private $updated;
		private $creatorId;

		/*
			An array of objects of the type QuestionGroup
		 */
		private $questionGroups;

		/*
			An array of examiners
		 */
		private $subExaminers;

		public function addQuestionGroup($questionGroup){

		}

		public function getQuestionGroup($questionGroupId){

		}

		public function removeQuestionGroup($questionGroupId){

		}


		/*
			Data Methods
		 */
		public function insert(){

		}

		public function update(){

		}


		/*
			Get and Set methods bellow
		 */
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->setEdited(true);
			$this->id = $id;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		pulbic function getDescription(){
			return $this->description;
		}

		public function setDescription($description){
			$this->description = $description;
		}
	}