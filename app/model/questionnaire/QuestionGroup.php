<?php
	include_once 'Question.php';

	class QuestionGroup extends DataObject{

		private $id;
		private $name;
		private $description;
		private $altitude;
		private $longtitude;
		private $altitudeDeviation;
		private $longtitudeDeviation;



		/*
			Array with objects of the type Question
		 */
		private $questions;

		public function addQuestion($question){

		}

		public function getQuestion($questionId){

		}

		public function removeQuestion($questionId){

		}


		/*
			Data Methods
		 */
		public function insert(){

		}

		public function update(){

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

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		pulbic function getDescription(){
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
	}
