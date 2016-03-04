<?php
	include_once 'Answer.php';

	class Question {

		private $id; // number
		private $questionGroupId; // number
		private $questionText; // string 
		private $timeToAnswer; // number
		private $creation_date; // string , timestamp in database

		/*
			Array of objects of the type Answer
		*/
		private $answers;


		public function addAnswer($answer){
			$this->answers[$answer->getId()] = $answer;
		}

		public function getAnswer($answerId){
			return $this->answers[$answerId];
		}

		public function removeAnswer($answerId){
			unset($this->answers[$answerId]);
		}

		/*
			Set and Get methods bellow
		*/
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->setEdited(true);
			$this->id = $id;
		}
			
		public function getQuestionGroupId(){
			return $this->questionGroupId;
		}
		
		public function setQuestionGroupId($questionGroupId){
			$this->questionGroupId = $questionGroupId;
		}

		public function getQuestionText(){
			return $this->questionText;
		}

		public function setQuestionText($questionText){
			$this->setEdited(true);
			$this->questionText = $questionText;
		}

		public function getTimeToAnswer(){
			return $this->timeToAnswer;
		}

		public function setTimeToAnswer($timeToAnswer){
			$this->setEdited(true);
			$this->timeToAnswer = $timeToAnswer;
		}

		public function getCreationDate(){
			return $this->creationDate;
		}
		
		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}