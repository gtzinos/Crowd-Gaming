<?php
	include_once 'Answer.php';

	class Question extends DataObject{

		private $id;
		private $name;
		private $questionText;
		private $timeToAnswer;

		/*
			Array of objects of the type Answer
		*/
		private $answers;



		public function addAnswer($answer){

		}

		public function getAnswer($answerId){

		}

		public function removeAnswer($answerId){

		}


		/*
			Data Methods
		 */
		
		public function update(){

		}

		public function insert(){

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