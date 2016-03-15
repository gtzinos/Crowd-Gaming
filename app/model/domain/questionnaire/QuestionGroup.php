<?php
	include_once 'Question.php';

	class QuestionGroup {

		private $id; // number
		private $questionnaireId; // number
		private $name; // string
		private $description; // string
		private $altitude; // number
		private $longitude; // number
		private $altitudeDeviation; // number
		private $longitudeDeviation; // number
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
			$this->altitude = $altitude;
		}

		public function getLongitude(){
			return $this->longitude;
		}

		public function setLongitude($longitude){
			$this->longitude= $longitude;
		}

		public function getAltitudeDeviation(){
			return $this->altitudeDeviation;
		}

		public function setAltitudeDeviation($altitudeDeviation){
			$this->altitudeDeviation = $altitudeDeviation;
		}

		public function getLongitudeDeviation(){
			return $this->longitudeDeviation;
		}

		public function setLongitudeDeviation($longitudeDeviation){
			$this->longitudeDeviation= $longitudeDeviation;
		}

		public function getCreationDate(){
			return $this->creationDate;
		}
		
		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}
