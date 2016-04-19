<?php
	class Answer{
		private $id;
		private $questionId;
		private $correct;
		private $answerText;
		private $creationDate;

		/*
			Set and Get Methods bellow
		 */
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getQuestionId(){
			return $this->questionId;
		}
		
		public function setQuestionId($questionId){
			$this->questionId = $questionId;
		}

		public function getDescription(){
			return $this->description;
		}
		
		public function setDescription($description){
			$this->description = $description;
		}

		public function isCorrect(){
			return $this->correct;
		}

		public function setCorrect($correct){
			$this->correct = $correct;
		}

		public function getAnswerText(){
			return $this->answerText;
		}

		public function setAnswerText($answerText){
			$this->answerText = $answerText;
		}

		public function getCreationDate(){
			return $this->creationDate;
		}
		
		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}