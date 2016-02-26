<?php
	include_once 'Answer.php';

	class Question {

		private $id;
		private $name;
		private $questionText;
		private $timeToAnswer;

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
	
		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->setEdited(true);
			$this->name = $name;
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

		
	}