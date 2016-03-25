<?php
	
	class UserAnswer{

		private $userId; // int
		private $answerId; // int
		private $questionId; // int
		private $latitude; // string
		private $longitude; // string
		private $answeredTime; // float
		private $isCorrect; // boolean

		public function getUserId(){
			return $this->userId;
		}
		
		public function setUserId($userId){
			$this->userId = $userId;
		}

		public function getAnswerId(){
			return $this->answerId;
		}
		
		public function setAnswerId($answerId){
			$this->answerId = $answerId;
		}

		public function getQuestionId(){
			return $this->questionId;
		}
		
		public function setQuestionId($questionId){
			$this->questionId = $questionId;
		}

		public function getLatitude(){
			return $this->latitude;
		}
		
		public function setLatitude($latitude){
			$this->latitude = $latitude;
		}

		public function getLongitude(){
			return $this->longitude;
		}
		
		public function setLongitude($longitude){
			$this->longitude = $longitude;
		}

		public function getAnsweredTime(){
			return $this->answeredTime;
		}
		
		public function setAnsweredTime($answeredTime){
			$this->answeredTime = $answeredTime;
		}

		public function getCorrect(){
			return $this->isCorrect;
		}
		
		public function setCorrect($isCorrect){
			$this->isCorrect = $isCorrect;
		}
	}