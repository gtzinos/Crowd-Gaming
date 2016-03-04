<?php
	include_once 'Question.php';

	class QuestionGroup {

		private $id; // number
		private $questionnaireId; // number
		private $name; // string
		private $description; // string
		private $altitude; // number
		private $longtitude; // number
		private $altitudeDeviation; // number
		private $longtitudeDeviation; // number
		private $creationDate; // string , timestamp in database

		/*
			Array with objects of the type Question
		 */
		private $questions;

		public function addQuestion($question){
			$this->questions[$question->getId()] = $question;
		}

		public function getQuestion($questionId){
			return $this->questions[$questionId];
		}

		public function removeQuestion($questionId){
			unset($this->questions[$questionId]);
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

		public function getQuestionnaireId(){
			return $this->questionnaireId;
		}
		
		public function setQuestionnaireId($questionnaireId){
			$this->questionnaireId = $questionnaireId;
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

		public function getAltitude(){
			return $this->altitude;
		}

		public function setAltitude($altitude){
			$this->setEdited(true);
			$this->altitude = $altitude;
		}

		public function getLongtitude(){
			return $this->longtitude;
		}

		public function setLongtitude($longtitude){
			$this->setEdited(true);
			$this->longtitude= $longtitude;
		}

		public function getAltitudeDeviation(){
			return $this->altitudeDeviation;
		}

		public function setAltitudeDeviation($altitudeDeviation){
			$this->setEdited(true);
			$this->altitudeDeviation = $altitudeDeviation;
		}

		public function getLongtitudeDeviation(){
			return $this->longtitudeDeviation;
		}

		public function setLongtitudeDeviation($longtitudeDeviation){
			$this->setEdited(true);
			$this->longtitudeDeviation= $longtitudeDeviation;
		}

		public function getCreationDate(){
			return $this->creationDate;
		}
		
		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}
