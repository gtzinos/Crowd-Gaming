<?php

	class ExaminerApplication{

		private $id;
		private $accepted;
		private $applicationText;
		private $applicationDate;

		public function getId(){
			return $this->id;
		}
			
		public function setId($id){
			$this->id = $id;
		}

		public function isAccepted(){
			return $this->accepted;
		}

		public function isAnswered(){
			return isset($this->accepted);
		}
		
		public function setAccepted($accepted){
			$this->accepted = $accepted;
		}

		public function getApplicationText(){
			return $this->applicationText;
		}
		
		public function setApplicationText($applicationText){
			$this->applicationText = $applicationText;
		}

		public function getApplicationDate(){
			return $this->applicationDate;
		}
		
		public function setApplicationDate($applicationDate){
			$this->applicationDate = $applicationDate;
		}
	}	