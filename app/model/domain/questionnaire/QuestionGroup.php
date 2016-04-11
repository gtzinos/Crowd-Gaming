<?php
	include_once 'Question.php';

	class QuestionGroup {

		private $id; // number
		private $questionnaireId; // number
		private $name; // string
		private $latitude; // number
		private $longitude; // number
		private $radius; // number
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

		public function getRadius(){
			return $this->radius;
		}
		
		public function setRadius($radius){
			$this->radius = $radius;
		}

		public function getCreationDate(){
			return $this->creationDate;
		}
		
		public function setCreationDate($creationDate){
			$this->creationDate = $creationDate;
		}
	}
