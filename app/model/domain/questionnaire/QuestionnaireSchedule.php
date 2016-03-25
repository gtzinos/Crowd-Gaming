<?php
	
	class QuestionnaireSchedule{

		private $id; // number
		private $questionnaireId; //number
		private $day; // number
		private $startTime; // int, counts minutes from 00:00
		private $startDate; // string , date
		private $endTime; // int , coutns minutes from 00:00
		private $endDate; // string , date


		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}

		public function getQuestionnaireId(){
			return $this->questionnaireId;
		}
		
		public function setQuestionnaireId($questionnaireId){
			$this->questionnaireId = $questionnaireId;
		}

		public function getDay(){
			return $this->day;
		}
		
		public function setDay($day){
			$this->day = $day;
		}

		public function getStartTime(){
			return $this->startTime;
		}
		
		public function setStartTime($startTime){
			$this->startTime = $startTime;
		}

		public function getStartDate(){
			return $this->startDate;
		}
		
		public function setStartDate($startDate){
			$this->startDate = $startDate;
		}

		public function getEndTime(){
			return $this->endTime;
		}
		
		public function setEndTime($endTime){
			$this->endTime = $endTime;
		}

		public function getEndDate(){
			return $this->endDate;
		}
		
		public function setEndDate($endDate){
			$this->endDate = $endDate;
		}

	}