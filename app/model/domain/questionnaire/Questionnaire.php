<?php

	include_once 'QuestionGroup.php';


	class Questionnaire{

		private $id;
		private $name;
		private $description;
		private $language;
		private $public;
		private $creationDate;
		private $coordinatorId;

		/*
			An array of objects of the type QuestionGroup
		 */
		private $questionGroups;

		/*
			An array of examiners
		 */
		private $subExaminers;


		public function addQuestionGroup($questionGroup){
			$this->questionGroups[$questionGroup->getId()] = $questionGroup;
		}

		public function getQuestionGroup($questionGroupId){
			return $this->questionGroup[$questionGroupId];
		}

		public function removeQuestionGroup($questionGroupId){
			unset($this->questionGroup[$questionGroupId]);
		}

		public function addSubExaminer($subExaminer){
			$this->subExaminers[$subExaminer->getId()] = $subExaminer;
		}

		public function getSubExaminer($subExaminerId){
			return $this->subExaminers[$subExaminerId];
		}

		public function removeSubExaminer($subExaminerId){
			unset($this->subExaminers[$subExaminerId]);
		}

		/*
			Get and Set methods bellow
		 */
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getDescription(){
			return $this->description;
		}

		public function setDescription($description){
			$this->description = $description;
		}

		public function getSmallDescription(){
			$description = $this->description;

			$description = strip_tags($description);

			if( count($description) > 30 )
				$description = substr($description, 30);

			return $description;
		}

		public function getPublic(){
			return $this->public;
		}

		public function setPublic($public){
			$this->public = $public;
		}
		public function getCoordinatorId(){
			return $this->coordinatorId;
		}

		public function setCoordinatorId($coordinatorId){
			$this->coordinatorId = $coordinatorId;
		}

		public function getLanguage(){
			return $this->language;
		}

		public function setLanguage($language){
			$this->language = $language;
		}

		public function getCreationDate() {
			$dateParts = explode(" ",$this->creationDate);
			return $dateParts[0];
		}

		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}
