<?php
	include_once 'Question.php';

	class QuestionGroup {

		private $id; // number
		private $questionnaireId; // number
		private $name; // string
		private $description; // string
		private $latitude; // number
		private $longitude; // number
		private $latitudeDeviation; // number
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
			$this->longitude= $longitude;
		}

		public function getLatitudeDeviation(){
			return $this->latitudeDeviation;
		}

		public function setLatitudeDeviation($latitudeDeviation){
			$this->latitudeDeviation = $latitudeDeviation;
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
