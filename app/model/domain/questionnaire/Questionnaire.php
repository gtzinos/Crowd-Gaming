<?php 

	include_once 'QuestionGroup.php';


	class Questionnaire{

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