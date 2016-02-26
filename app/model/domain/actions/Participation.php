<?php

	class Participation{

		private $userId; // number
		private $questionnaireId; //number;
		private $participationType; // number;
		private $participationDate; // string here , timestamp in dbms;

		public function getUserId(){
			return $this->userId;
		}
		
		public function setUserId($userId){
			$this->userId = $userId;
		}

		public function getQuestionnaireId(){
			return $this->questionnaireId;
		}
		
		public function setQuestionnaireId($questionnaireId){
			$this->questionnaireId = $questionnaireId;
		}
		
		public function getParticipationType(){
			return $this->participationType;
		}
		
		public function setParticipationType($participationType){
			$this->participationType = $participationType;
		}

		public function getParticipationDate(){
			return $this->participationDate;
		}
		
		public function setParticipationDate($participationDate){
			$this->participationDate = $participationDate;
		}

	}